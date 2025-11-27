<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddReviewFieldsToCertificates extends Migration
{
    public function up()
    {

        $fields = [
                    'reviewed_at' => [
                        'type' => 'DATETIME',
                        'null' => true,
                        'after' => 'status'  // optional
                    ],
                    'reviewed_by' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'null' => true,
                        'after' => 'reviewed_at' // optional
                    ],
                ];

        $this->forge->addColumn('ecomm_certificates_data', $fields);

    }

    public function down()
    {

        // Reverse both columns
        $this->forge->dropColumn('ecomm_certificates_data', ['reviewed_at', 'reviewed_by']);

    }
}
