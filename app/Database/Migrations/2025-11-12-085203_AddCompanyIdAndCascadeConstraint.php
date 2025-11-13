<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsForCertificates extends Migration
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        // ✅ Explicit DB connection
        $this->db = \Config\Database::connect();
    }

    /**
     * Check if a column exists in a given table
     */
    protected function columnExists(string $table, string $column): bool
    {
        $fields = $this->db->getFieldData($table);
        foreach ($fields as $field) {
            if ($field->name === $column) {
                return true;
            }
        }
        return false;
    }

    public function up()
    {
        /**
         * 1️⃣ Add company_id to ecomm_certificates_data if missing
         */
        if (! $this->columnExists('ecomm_certificates_data', 'company_id')) {
            $this->forge->addColumn('ecomm_certificates_data', [
                'company_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                    'after'      => 'enquiry_id',
                ],
            ]);
        }

        /**
         * 2️⃣ Add enquiry_id to ecomm_company_certificates if missing
         * (nullable because certificate_type=0 doesn’t use it)
         */
        if (! $this->columnExists('ecomm_company_certificates', 'enquiry_id')) {
            $this->forge->addColumn('ecomm_company_certificates', [
                'enquiry_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                    'after'      => 'id', // adjust if your table has a different primary key name
                ],
            ]);
        } else {
            // make enquiry_id nullable if it exists
            $this->forge->modifyColumn('ecomm_company_certificates', [
                'enquiry_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
            ]);
        }

        /**
         * 3️⃣ Add certificate_type column (default = 0)
         */
        if (! $this->columnExists('ecomm_company_certificates', 'certificate_type')) {
            $this->forge->addColumn('ecomm_company_certificates', [
                'certificate_type' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                    'comment'    => '0 = no enquiry, 1 = linked enquiry',
                    'after'      => 'enquiry_id',
                ],
            ]);
        }
    }

    public function down()
    {
        // Rollback safely
        if ($this->columnExists('ecomm_certificates_data', 'company_id')) {
            $this->forge->dropColumn('ecomm_certificates_data', 'company_id');
        }

        if ($this->columnExists('ecomm_company_certificates', 'enquiry_id')) {
            $this->forge->dropColumn('ecomm_company_certificates', 'enquiry_id');
        }

        if ($this->columnExists('ecomm_company_certificates', 'certificate_type')) {
            $this->forge->dropColumn('ecomm_company_certificates', 'certificate_type');
        }
    }
}
