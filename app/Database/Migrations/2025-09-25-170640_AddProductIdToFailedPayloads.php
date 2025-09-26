<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductIdToFailedPayloads extends Migration
{
    public function up()
    {
        $fields = ['item_id' => [
                            'type' => 'INT','null' => false]

        ];

        $this->forge->addColumn('ecomm_failed_payloads', $fields);
    }

    public function down()
    {

        $this->forge->dropColumn('ecomm_failed_payloads', ['item_id']);

    }
}
