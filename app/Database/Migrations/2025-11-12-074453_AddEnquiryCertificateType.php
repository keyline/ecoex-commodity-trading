<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEnquiryCertificateType extends Migration
{
    public function up()
    {

        // Add enquiry_id column
        $this->forge->addColumn('ecomm_company_certificates', [
            'enquiry_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => 0,
                'after' => 'company_id'
            ]
        ]);

        // Add certificate_type column
        $this->forge->addColumn('ecomm_company_certificates', [
            'certificate_type' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => '0=normal certificate, 1=enquiry type',
                'after' => 'enquiry_id'
            ]
        ]);

        // Add index for better query performance
        $this->forge->addKey('enquiry_id', false, false, 'ecomm_company_certificates');
        $this->forge->addKey('certificate_type', false, false, 'ecomm_company_certificates');

    }

    public function down()
    {

        $this->forge->dropColumn('ecomm_company_certificates', ['enquiry_id', 'certificate_type']);

    }
}
