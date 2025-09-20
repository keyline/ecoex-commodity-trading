<?php

namespace App\Listeners;

use App\Models\WhatsAppWorkerModel;

class EnquiryCreatedListener
{
    public function handle($enquiry)
    {
        // $enquiry is what the event sends (array)
        $model = new WhatsAppWorkerModel();


        $row = [
        'enquiry_id' => $enquiry['id'] ?? null,
        'status' => 'new',
        'enquiry_meta' => json_encode($enquiry),
        'created_at' => date('Y-m-d H:i:s'),
        ];


        $model->insert($row);
    }
}
