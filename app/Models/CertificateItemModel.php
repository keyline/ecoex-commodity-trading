<?php

// ============================================
// 3. CERTIFICATE ITEM MODEL
// ============================================
// File: app/Models/CertificateItemModel.php

namespace App\Models;

use CodeIgniter\Model;

class CertificateItemModel extends Model
{
    protected $table = 'ecomm_certificate_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'certificate_id', 'item_description', 'quantity', 'unit', 'sequence'
    ];
}
