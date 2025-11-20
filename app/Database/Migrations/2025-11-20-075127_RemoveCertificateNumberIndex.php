<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveCertificateNumberIndex extends Migration
{
    public function up()
    {

        // Drop the unique index on certificate_number column
        $this->forge->dropKey('ecomm_certificates_data', 'certificate_number', true);

    }

    public function down()
    {

        // Re-add the unique index if rollback needed
        $this->forge->addKey('certificate_number', true);
        $this->forge->processIndexes('ecomm_certificates_data');

    }
}
