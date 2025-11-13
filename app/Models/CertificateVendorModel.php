<?php

// ============================================
// NEW MODEL FOR VENDORS
// ============================================
// File: app/Models/CertificateVendorModel.php

namespace App\Models;

use CodeIgniter\Model;

class CertificateVendorModel extends Model
{
    protected $table = 'ecomm_certificate_vendors';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'certificate_id', 'vendor_id', 'company_name', 'sequence'
    ];

    protected $validationRules = [
        'certificate_id' => 'required|integer',
        'company_name' => 'required|max_length[255]',
    ];
}
