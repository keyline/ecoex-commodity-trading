<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFailedPayload extends Migration
{
    public function up()
    {

        $this->forge->addField([
                'id'          => ['type' => 'BIGINT','unsigned' => true,'auto_increment' => true],
                'job_id'      => ['type' => 'INT','constraint' => 11],
                'recipient'   => ['type' => 'VARCHAR','constraint' => 50],
                'payload'     => ['type' => 'TEXT'],
                'attempts'    => ['type' => 'INT','default' => 0],
                'last_error'  => ['type' => 'TEXT','null' => true],
                'created_at'  => ['type' => 'DATETIME','null' => true],
            ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ecomm_failed_payloads');

    }

    public function down()
    {
        $this->forge->dropTable('ecomm_failed_payloads');
    }
}
