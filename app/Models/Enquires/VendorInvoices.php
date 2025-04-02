<?php

namespace App\Models\Enquires;

use CodeIgniter\Model;

class VendorInvoices extends Model
{
    protected $table            = 'ecomm_enquires_vendor_invoices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    // protected $protectFields    = true;
    protected $allowedFields    = [
        'sub_enq_id',
        'enq_id',
        'vendor_invoice_amount',
        'vendor_invoice_file',
        'status'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'sub_enq_id'            => 'required|integer',
        'enq_id'                => 'required|integer',
        'vendor_invoice_amount' => 'required|decimal',
        'vendor_invoice_file'   => 'required|string|max_length[255]',
        'status'                => 'required|in_list[pending,approved,rejected]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;



}
