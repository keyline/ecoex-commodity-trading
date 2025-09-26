<?php

// app/Commands/ProcessWhatsappJobs.php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Predis\Client as Redis;
use App\Models\WhatsAppWorkerModel;
use App\Services\WhatsApp\DigitalSmsWhatsAppProvider;
use App\Services\WhatsApp\WhatsAppMessageService;
use App\Services\WhatsApp\WhatsAppException;

class ProcessWhatsappJobs extends BaseCommand
{
    protected $group = 'WhatsApp';
    protected $name  = 'whatsapp:process';
    protected $description = 'Process whatsapp jobs from database queue (one job at a time)';
    protected $perJobSleep = 1; // optional throttle between recipients

    private $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function run(array $params)
    {
        //$redis = new Redis();

        $jobId = $params[0] ?? null;

        if (!$jobId) {

            CLI::error("Job ID is required");

            log_message('error', "Unexpected error processing job with ID {$jobId}: ");

            return;
        }



        $jobModel = new WhatsAppWorkerModel();

        //$failedModel = new \App\Models\FailedPayloadModel();


        $job = $jobModel->find($jobId);


        // pop one job at a time
        //while ($entry = $redis->rpop('whatsapp_jobs_queue'))

        $jobId = $job['id'];

        CLI::write("Processing Job ID: {$jobId}");
        //$jobRow = $db->table('jobs_logs')->where('id',$jobId)->get()->getRow();

        //if (!$jobRow)
        if (!$jobId) {
            CLI::error("Job {$jobId} not found. Skipping.");
            return;
        }

        // mark in_progress
        $jobModel->update($jobId, [
            'status' => 'processing',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        //$payload = json_decode($job['enquiry_meta'], true);
        //$recipients = $payload['recipients'] ?? [];
        //$recipients = ['9903985585', '8910649429', '6289339520', '8981374267']; // Replace with actual recipient numbers

        $sql = "SELECT ecomm_users.phone FROM ecomm_users WHERE ecomm_users.type='VENDOR' and ecomm_users.phone IS NOT NULL AND ecomm_users.phone <> ''
                        UNION
                    SELECT subscribers.phone FROM subscribers WHERE subscribers.phone IS NOT NULL AND subscribers.phone <> ''";


        $query = $this->db->query($sql);
        $recipientResult = $query->getResultArray();
        $recipients = array_column($recipientResult, 'phone');

        //getting items send in message
        //one item per message
        $builder = $this->db->table('ecomm_enquires ee');
        $builder->select("
                        ee.id   AS enquiry_id,
                        ci.id   AS enquiry_product_id,
                        ep.new_product_image AS media_url,
                        ep.qty,
                        ep.unit,
                        ci.price_range AS price_range,
                        ci.id   AS item_id,
                        ci.item_name_ecoex AS material,
                        u.plant_name,
                        u.district,
                        u.state,
                        unit.name AS unit_name
                    ");
        $builder->join('ecomm_enquiry_products ep', 'ee.id = ep.enq_id');
        $builder->join('ecomm_company_items ci', 'ep.product_id = ci.id');
        $builder->join('ecomm_users u', 'ep.plant_id = u.id');
        $builder->join('ecomm_units unit', 'unit.id = ci.unit');
        $builder->where('ee.id', $job['enquiry_id']);
        $builder->orderBy('ep.id');

        $query   = $builder->get();
        $items = $query->getResultArray();
        $recipientCount = count($recipients);

        $messagesPerRecipient = count($items); // minimum
        $providerLimitPerSecond = 10;

        $perMessageDelay = 1 / $providerLimitPerSecond;
        $this->perJobSleep = $messagesPerRecipient * $perMessageDelay;



        try {
            $whatsAppProvider = new DigitalSmsWhatsAppProvider();
            $whatsAppService  = new WhatsAppMessageService($whatsAppProvider);

            //getting data from db to build items to send
            foreach ($recipients as $recipient) {
                try {

                    $result = $whatsAppService->sendWithRetry($recipient, $items, $job['id']);




                } catch (\Throwable $th) {

                    log_message('error', "Unexpected error for recipient {$recipient}: " . $th->getMessage());


                }


                // Throttle: wait enough so we don’t exceed provider rate
                usleep($this->perJobSleep * 1_000_000); // convert seconds → microseconds



            }


        } catch (\Exception $ex) {
            //throw $th;

            log_message('error', "Unexpected error processing job id {$jobId}: " . $ex->getMessage());

        }



        // final status update: check if any failed for this job
        //$failedCount = $db->table('failed_payloads')->where('job_id', $jobId)->countAllResults();
        //$processed = $db->table('jobs_logs')->where('id', $jobId)->get()->getRow()->processed ?? 0;
        //$total = $db->table('jobs_logs')->where('id', $jobId)->get()->getRow()->total ?? count($recipients);





        //$failedCount = $failedModel->where('job_id', $jobId)->countAllResults();

        // Mark job as finished
        $jobModel->update($jobId, [
            'status'      => 'finished',
            'total_recipients' => $recipientCount,
            'total_messages' => $recipientCount * $messagesPerRecipient,
            //'failed'        => $failedCount,
            'finished_at' => date('Y-m-d H:i:s')
        ]);



        CLI::write("Job {$jobId} completed");

    }
}
