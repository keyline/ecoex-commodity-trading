<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PrepareCertificateDataModel extends Migration
{
    public function up()
    {

        // Main certificates table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'enquiry_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'enquiry_no' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'certificate_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
            ],
            'company_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'plant_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'plant_address' => [
                'type' => 'TEXT',
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'collection_date' => [
                'type' => 'DATE',
            ],
            'issue_date' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'finalized'],
                'default' => 'draft',
            ],
            'version' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
            ],
            'signature_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'pdf_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'finalized_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'finalized_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'updated_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('enquiry_id');
        $this->forge->addKey('status');
        $this->forge->createTable('ecomm_certificates_data');

        // Certificate items table (for scrap materials)
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
            'item_description' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'quantity' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'unit' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'sequence' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('certificate_id');
        $this->forge->addForeignKey('certificate_id', 'ecomm_certificates_data', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ecomm_certificate_items');

        // Version history table
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
            'version_number' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'data_snapshot' => [
                'type' => 'JSON',
            ],
            'changed_by' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'change_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('certificate_id');
        $this->forge->createTable('ecomm_certificate_versions');

    }

    public function down()
    {

        $this->forge->dropTable('ecomm_certificate_versions');
        $this->forge->dropTable('ecomm_certificate_items');
        $this->forge->dropTable('ecomm_certificates_data');

    }
}
