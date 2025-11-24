<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCTOToUserAndCertificateVendors extends Migration
{
    public function up()
    {

        // Add column to ecomm_users
        $fieldsUsers = [
            'cto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'default'    => null,
                'after'      => 'contact_person_document' // optional: position the column
            ],
        ];
        $this->forge->addColumn('ecomm_users', $fieldsUsers);


        // Add column to ecomm_certificate_vendors
        $fieldsCertVendors = [
            'cto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'default'    => null,
                'after'      => 'company_name' // optional
            ],
        ];
        $this->forge->addColumn('ecomm_certificate_vendors', $fieldsCertVendors);


    }

    public function down()
    {

        // Drop the columns on rollback
        $this->forge->dropColumn('ecomm_users', ['cto']);
        $this->forge->dropColumn('ecomm_certificate_vendors', ['cto']);

    }
}
