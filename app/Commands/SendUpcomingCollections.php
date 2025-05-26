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

    public function run(array $params)
    {
        helper('common');
        $today = (new DateTime())->format('Y-m-d');
        $inTen = (new DateTime('+10 days'))->format('Y-m-d');

        $db      = \Config\Database::connect();
        $builder = $db->table('ecomm_enquires');
        $builder
            ->select("id, enquiry_no, tentative_collection_date,
                       DATEDIFF(tentative_collection_date, CURDATE()) AS days_until", false)
            ->where('status', 6)
            ->where("tentative_collection_date BETWEEN '{$today}' AND '{$inTen}'");
        $results = $builder->get()->getResultArray();

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

                $mailSent = sendEcoexMail(
                    '',
                    'Upcoming Collection Reminder',
                    view('email-templates/upcoming_collection', [
                        'enquiry'    => (object) $row,
                        'days_until' => $row['days_until'],
                    ])
                );
                log_message('debug', 'smtp mail Data: ' . var_dump($mailSent, true));
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
