<?php

// app/Commands/ProcessWhatsappJobsV2.php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\WhatsAppWorkerModel;
use App\Services\WhatsApp\DigitalSmsWhatsAppProvider;
use App\Services\WhatsApp\WhatsAppMessageService;
use App\Services\WhatsApp\WhatsAppException;
use Throwable;
use Config\Database;

class ProcessWhatsappJobsV2 extends BaseCommand
{
    protected $group = 'WhatsApp';
    protected $name = 'whatsapp:process_v2';
    protected $description = 'Process WhatsApp jobs sequentially (cron-friendly)';
    protected $perJobSleep = 1; // optional sleep between jobs

    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function run(array $params)
    {
        CLI::write("=== WhatsApp Job Processor Started at " . date('Y-m-d H:i:s') . " ===", 'green');

        $jobModel = new WhatsAppWorkerModel();
        $processed = 0;

        try {
            // Prevent overlap using lock file
            $lockFile = WRITEPATH . 'cache/whatsapp_job.lock';
            if (file_exists($lockFile)) {
                CLI::error("Another process is running. Exiting.");
                return;
            }
            file_put_contents($lockFile, getmypid());
            register_shutdown_function(static function () use ($lockFile) {
                @unlink($lockFile);
            });

            // Sequentially process pending jobs
            while (true) {
                /*$job = $jobModel
                    ->where('status', 'pending')
                    ->orderBy('created_at', 'ASC')
                    ->first();*/
                //Claim one job at a time
                $job = $jobModel->claimPending();

                if (!$job) {
                    CLI::write("No pending jobs found. Sleeping...", 'yellow');
                    sleep(10);
                    break; // Exit after idle
                }

                $jobId = $job['id'];
                CLI::write("Processing Job ID: {$jobId}", 'cyan');

                //preparing data

                //$testRecipients = ['9866186563', '9733159567']; // Replace with actual recipient numbers

                //$phones = array_filter(array_map('trim', $testRecipients));


                //$placeholders = implode(',', array_fill(0, count($phones), '?'));

                /*$sql = "SELECT ecomm_users.phone FROM ecomm_users WHERE ecomm_users.type='VENDOR' and ecomm_users.phone IS NOT NULL AND ecomm_users.phone <> ''
                                UNION
                            SELECT subscribers.phone FROM subscribers WHERE subscribers.phone IS NOT NULL AND subscribers.phone <> ''";*/
                //

                $builder = $this->db->table('ecomm_enquires enq');
                $builder->select('u.state');
                $builder->join('ecomm_users u', 'u.id = enq.plant_id');
                $builder->where('u.type', 'PLANT');
                $builder->where('enq.id', $job['enquiry_id']);

                $query = $builder->get();
                $result = $query->getRow();


                $sql = "SELECT phone, 'vendor' as source, state
                FROM ecomm_users 
                WHERE type = 'VENDOR' 
                  AND phone <> ''
                  AND state =?
                
                UNION
                
                SELECT phone, 'subscriber' as source, NULL as state
                FROM subscribers 
                WHERE phone <> ''";


                //$bindings = array_merge($phones, $phones);
                $query = $this->db->query($sql, [$result->state]);
                //$query = $this->db->query($sql);
                $recipientResult = $query->getResultArray();
                $recipients = array_column($recipientResult, 'phone');
                //$recipients = ['9903985585', '8910649429']; //test number

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


                // Mark job as finished
                $jobModel->update($jobId, [
                    'status'      => 'finished',
                    'total_recipients' => $recipientCount,
                    'total_messages' => $recipientCount * $messagesPerRecipient,
                    //'failed'        => $failedCount,
                    'finished_at' => date('Y-m-d H:i:s')
                ]);






                CLI::write(sprintf("=== Processing Completed: %d message(s) delivered ===", count($recipients)), 'green');


            }



        } catch (Throwable $th) {
            log_message('critical', "[CronJob] Uncaught exception: " . $th->getMessage());
            CLI::error("Fatal error in job processor: " . $th->getMessage());
        }
    }
}
