<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyStatusColumnInCertificatedata extends Migration
{
    public function up()
    {

        // 1. Drop old column
        $this->forge->dropColumn('ecomm_certificates_data', 'status');


        // 2. Add new ENUM column
        $fields = [
            'status' => [
                'type'       => "ENUM('pending','review','approved','rejected')",
                'default'    => 'pending',
                'null'       => false,
                'collation'  => 'utf8_general_ci'
            ]
        ];

        $this->forge->addColumn('ecomm_certificates_data', $fields);

    }

    public function down()
    {

        // reverse process

        // Drop the updated column
        $this->forge->dropColumn('ecomm_certificates_data', 'status');

        // Recreate original ENUM column
        $fields = [
            'status' => [
                'type'       => "ENUM('draft','finalized')",
                'default'    => 'draft',
                'null'       => false,
                'collation'  => 'utf8_general_ci'
            ]
        ];

        $this->forge->addColumn('ecomm_certificates_data', $fields);

    }
}
