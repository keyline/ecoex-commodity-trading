<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWordColumnsToCertificatesTables extends Migration
{
    public function up()
    {


        // Add column to ecomm_certificates_data
        $this->forge->addColumn('ecomm_certificates_data', [
            'word_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'pdf_path' // adjust based on your table
            ],
        ]);

        // Add columns to ecomm_company_certificates
        $this->forge->addColumn('ecomm_company_certificates', [
            'certificate_word_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'certificate_file', // adjust accordingly
            ],
            'word_filename' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'filename',
            ],
        ]);


    }

    public function down()
    {

        // Reverse changes
        $this->forge->dropColumn('ecomm_certificates_data', 'word_path');
        $this->forge->dropColumn('ecomm_company_certificates', 'certificate_word_file');
        $this->forge->dropColumn('ecomm_company_certificates', 'word_filename');

    }
}
