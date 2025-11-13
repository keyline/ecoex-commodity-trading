<?php

// ============================================
// 4. CERTIFICATE VERSION MODEL
// ============================================
// File: app/Models/CertificateVersionModel.php

namespace App\Models;

use CodeIgniter\Model;

class CertificateVersionModel extends Model
{
    protected $table = 'ecomm_certificate_versions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'certificate_id', 'version_number', 'data_snapshot',
        'changed_by', 'change_notes', 'created_at'
    ];
}
