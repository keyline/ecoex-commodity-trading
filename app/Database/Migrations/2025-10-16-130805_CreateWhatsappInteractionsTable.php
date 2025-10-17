<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateWhatsappInteractionsTable extends Migration
{
    public function up()
    {

        $this->forge->addField([
                    'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
                    'enquiry_id'     => ['type' => 'INT', 'null' => true],
                    'product_id'     => ['type' => 'INT', 'null' => true],
                    'wa_id'          => ['type' => 'VARCHAR', 'constraint' => 20],
                    'user_name'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                    'button_action'  => ['type' => 'VARCHAR', 'constraint' => 50],
                    'raw_payload'    => ['type' => 'TEXT', 'null' => true],
                    'created_at'     => [
                        'type' => 'DATETIME',
                        'null' => true,
                        'default' => new RawSql('CURRENT_TIMESTAMP')],
                ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('whatsapp_interactions');

    }

    public function down()
    {

        $this->forge->dropTable('whatsapp_interactions');

    }
}
