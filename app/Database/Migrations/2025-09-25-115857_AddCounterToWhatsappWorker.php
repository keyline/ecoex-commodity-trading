<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCounterToWhatsappWorker extends Migration
{
    public function up()
    {

        $fields = [
                    'total_recipients' => [
                        'type'       => 'INT',
                        'constraint' => 11,
                        'default'    => 0,
                        'after'      => 'status', // place after 'status' column
                    ],
                    'total_messages' => [
                        'type'       => 'INT',
                        'constraint' => 11,
                        'default'    => 0,
                        'after'      => 'total_recipients',
                    ],
                    'failed' => [
                        'type'       => 'INT',
                        'constraint' => 11,
                        'default'    => 0,
                        'after'      => 'total_messages',
                    ],
                ];

        $this->forge->addColumn('ecomm_whatsapp_workers', $fields);

    }

    public function down()
    {

        $this->forge->dropColumn('ecomm_whatsapp_workers', ['total_recipients', 'total_messages', 'failed']);

    }
}
