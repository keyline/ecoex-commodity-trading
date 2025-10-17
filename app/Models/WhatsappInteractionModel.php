<?php

namespace App\Models;

use CodeIgniter\Model;

class WhatsappInteractionModel extends Model
{
    protected $table = 'whatsapp_interactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'enquiry_id',
        'product_id',
        'wa_id',
        'user_name',
        'button_action',
        'raw_payload',
        'created_at'
    ];
    protected $useTimestamps = false;
}
