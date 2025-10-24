<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSendTypeToEcommWhatsappWorkers extends Migration
{
    public function up()
    {

        $this->forge->addColumn('ecomm_whatsapp_workers', [
                    'send_type' => [
                        'type'       => 'ENUM',
                        'constraint' => ['state', 'pan_India'],
                        'default'    => 'state',
                        'null'       => false,
                        'after'      => 'id', // adjust to desired position
                    ],
                ]);

    }

    public function down()
    {

        $this->forge->dropColumn('ecomm_whatsapp_workers', 'send_type');

    }
}
