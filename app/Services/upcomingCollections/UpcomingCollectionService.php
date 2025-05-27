<?php

namespace App\Services\UpcomingCollections;

use DateTime;

class UpcomingCollectionService
{

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getGeneralSettings()
    {
        return $this->db->table('general_settings')
            ->select('site_mail, system_email')
            ->get()
            ->getRow();
    }

    public function getUpcomingEnquiries()
    {
        $today = (new DateTime())->format('Y-m-d');
        $inTen = (new DateTime('+10 days'))->format('Y-m-d');

        $builder = $this->db->table('ecomm_enquires e');

        $builder
            ->select("
                e.id,
                e.enquiry_no,
                e.tentative_collection_date,
                DATEDIFF(e.tentative_collection_date, CURDATE()) AS days_until
            ", false)
            ->select('plant.company_name AS plant_name', false)
            ->select('main_comp.company_name AS company_name', false)
            ->select("
                CONCAT(
                    '[',
                        REPLACE(
                            GROUP_CONCAT(
                                JSON_OBJECT(
                                    'sub_id', sub.id,
                                    'vendor_id', sub.vendor_id,
                                    'vendor_name', vendor.company_name,
                                    'vendor_company', comp.company_name,
                                    'item_id', sub.item_id,
                                    'item_name', item.item_name_ecoex,
                                    'weighted_qty', sub.weighted_qty,
                                    'weighted_unit', sub.weighted_unit
                                ) SEPARATOR ','
                            ) COLLATE utf8mb4_unicode_ci,
                            '},{',
                            '},{'
                        ),
                    ']'
                ) AS sub_enquiries
            ", false)
            ->join('ecomm_users plant', 'e.plant_id = plant.id')
            ->join('ecoex_companies main_comp', 'e.company_id = main_comp.id')
            ->join('ecomm_sub_enquires sub', 'sub.enq_id = e.id')
            ->join('ecomm_users vendor', 'sub.vendor_id = vendor.id')
            ->join('ecoex_companies comp', 'e.company_id = comp.id')
            ->join('ecomm_company_items item', 'sub.item_id = item.id')
            ->where('e.status', 6)
            ->where("e.tentative_collection_date BETWEEN '{$today}' AND '{$inTen}'", null, false)
            ->groupBy([
                'e.id',
                'e.enquiry_no',
                'e.tentative_collection_date',
                'plant.company_name',
                'main_comp.company_name',
            ]);

        return $builder->get()->getResultArray();
    }

    public function sendReminderEmail()
    {
        helper('common');
        $gen     = $this->getGeneralSettings();
        $results = $this->getUpcomingEnquiries();
        $send_to = $gen->site_mail;

        // pr($results);

        try {
            $send_to = 'shubhadip.sinha@keylines.net'; // Replace with the actual recipient email address or comment out for testing

            $subject = 'Upcoming Collection Reminder';
            $message = view('email-templates/upcoming_collection', [
                'data'    => $results,
            ]);
            // pr($message);
            $mailSent = send_mail($send_to, $subject, $message);

            if ($mailSent) {
                echo "Email sent for enquiry " . $send_to;
            } else {
                echo "Failed to send email for enquiry " . $send_to;
            }
        } catch (\Exception $e) {
            log_message('error', 'Email not send: ' . $e->getMessage());
        }
    }
}
