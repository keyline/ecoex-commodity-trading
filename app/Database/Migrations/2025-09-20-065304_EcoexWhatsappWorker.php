<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EcoexWhatsappWorker extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'enquiry_id' => [ 'type' => 'INT', 'constraint' => 11, 'null' => false ],
            'status' => [ 'type' => 'VARCHAR', 'constraint' => 50, 'default' => 'new' ],
            'enquiry_meta' => [ 'type' => 'TEXT', 'null' => false ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => false ],
            'started_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'finished_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'last_error' => [ 'type' => 'TEXT', 'null' => true ],
            ]);


        $this->forge->addKey('id', true);
        $this->forge->createTable('ecomm_whatsapp_workers', true);
    }

    public function down()
    {
        $this->forge->dropTable('ecomm_whatsapp_workers');
    }
}
