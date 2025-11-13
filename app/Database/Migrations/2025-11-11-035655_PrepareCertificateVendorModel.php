<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PrepareCertificateVendorModel extends Migration
{
    public function up()
    {

        // Certificate vendors table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'certificate_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'vendor_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'company_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'sequence' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('certificate_id');
        $this->forge->addForeignKey('certificate_id', 'ecomm_certificates_data', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ecomm_certificate_vendors');

    }

    public function down()
    {
        $this->forge->dropTable('ecomm_certificate_vendors');
    }
}
