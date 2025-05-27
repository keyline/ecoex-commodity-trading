<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use DateTime;

class SendUpcomingCollections extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'send:upcoming-collections';
    protected $description = 'Enqueue reminder emails for next-10-day collections';
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    protected function genSettings()
    {
        return $this->db->table('general_settings')
            ->select('site_mail, system_email')
            ->get()
            ->getRow();
    }


    protected function getEnquiry()
    {
        $today = (new DateTime())->format('Y-m-d');
        $inTen = (new DateTime('+10 days'))->format('Y-m-d');
        // $db = \Config\Database::connect();

        $builder = $this->db->table('ecomm_enquires e');

        $builder
            // Main columns
            ->select("
        e.id,
        e.enquiry_no,
        e.tentative_collection_date,
        DATEDIFF(e.tentative_collection_date, CURDATE()) AS days_until
    ", false)
            // Joined lookup columns
            ->select('plant.company_name    AS plant_name', false)
            ->select('main_comp.company_name AS company_name', false)
            // The nested JSON / GROUP_CONCAT
            ->select("
        CONCAT(
          '[',
            REPLACE(
              GROUP_CONCAT(
                JSON_OBJECT(
                  'sub_id',        sub.id,
                  'vendor_id',     sub.vendor_id,
                  'vendor_name',   vendor.company_name,
                  'vendor_company',comp.company_name,
                  'item_id',       sub.item_id,
                  'item_name',     item.item_name_ecoex,
                  'weighted_qty',  sub.weighted_qty,
                  'weighted_unit', sub.weighted_unit
                ) SEPARATOR ','
              ) COLLATE utf8mb4_unicode_ci,
              '},{',
              '},{'
            ),
          ']'
        ) AS sub_enquiries
    ", false)
            // Joins
            ->join('ecomm_users          plant',     'e.plant_id     = plant.id')
            ->join('ecoex_companies      main_comp', 'e.company_id   = main_comp.id')
            ->join('ecomm_sub_enquires   sub',       'sub.enq_id     = e.id')
            ->join('ecomm_users          vendor',    'sub.vendor_id  = vendor.id')
            ->join('ecoex_companies      comp',      'e.company_id   = comp.id')
            ->join('ecomm_company_items  item',      'sub.item_id    = item.id')
            // Filters
            ->where('e.status', 6)
            ->where("e.tentative_collection_date BETWEEN '{$today}' AND '{$inTen}'", null, false)
            // Grouping for the aggregate
            ->groupBy([
                'e.id',
                'e.enquiry_no',
                'e.tentative_collection_date',
                'plant.company_name',
                'main_comp.company_name',
            ]);

        // Execute and fetch
        $results = $builder->get()->getResultArray();
        return $results;
    }




    public function run(array $params)
    {
        helper('common');
        $gen     = $this->genSettings();
        $results = $this->getEnquiry();
        $send_to = $gen->site_mail;
        // log('debug', 'Upcoming collections: ' . print_r($results, true));

        if (empty($results)) {
            CLI::write('No enquiries in the next 10 days.', 'yellow');
            return;
        }
        // ENQUEUE each job properly:
        // $queue = service('queue');
        foreach ($results as $row) {
            // $queue->push('emails', 'send-upcoming', $row);
            // CLI::write("Queued enquiry #{$row['enquiry_no']}", 'cyan');
            try {
                $send_to = 'shubhadip.sinha@keylines.net'; // Replace with the actual recipient email address or comment out for testing

                $subject = 'Upcoming Collection Reminder';
                $message = view('email-templates/upcoming_collection', [
                    'enquiry'    => (object) $row,
                    'days_until' => $row['days_until'],
                ]);

                $mailSent = send_mail($send_to, $subject, $message);
                // log_message('debug', 'smtp mail Data: ' . var_dump($mailSent, true));
                if ($mailSent) {
                    CLI::write("Email sent for enquiry #{$row['enquiry_no']}", 'green');
                } else {
                    CLI::write("Failed to send email for enquiry #{$row['enquiry_no']}", 'red');
                }
            } catch (\Exception $e) {
                log_message('error', 'Email not send: ' . $e->getMessage());
            }
        }
    }
}
