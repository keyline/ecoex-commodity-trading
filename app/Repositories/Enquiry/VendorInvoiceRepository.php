<?php

namespace App\Repositories\Enquiry;

use App\Models\Enquires\VendorInvoices;

class VendorInvoiceRepository
{
    protected $model;
    protected $db;
    public function __construct()
    {
        $this->model = new VendorInvoices();
        $this->db = \Config\Database::connect();
    }

    public function getSubEnquiry($sub_enquiry_no)
    {
        return  $this->db->table('ecomm_sub_enquires')
            ->select('vendor_id, enq_id, company_id, plant_id')
            ->where('sub_enquiry_no', $sub_enquiry_no)
            ->get()
            ->getRowArray();
    }

    public function updateData($table, $data, $whereColumn, $whereValue)
    {
        return $this->db->table($table)
            ->where($whereColumn, $whereValue)
            ->update($data);
    }

    // function getFCMTokens($vendor_id)
    // {
    //     return $this->db->table('ecomm_user_devices')
    //         ->select('fcm_token')
    //         ->where('user_id', $vendor_id)
    //         ->where('fcm_token !=', '')
    //         ->get()
    //         ->getResultArray();
    // }
}
