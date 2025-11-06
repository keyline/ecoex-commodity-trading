<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVendorIdsToEcoexAdminUser extends Migration
{
    public function up()
    {

        $fields = [
                    'vendor_ids' => [
                        'type'       => 'TEXT',
                        'null'       => true,
                        'after'      => 'plant_ids', // optional, to keep order
                        'comment'    => 'JSON array of vendor IDs linked to this user'
                    ]
                ];

        $this->forge->addColumn('ecoex_admin_user', $fields);

    }

    public function down()
    {

        $this->forge->dropColumn('ecoex_admin_user', 'vendor_ids');

    }
}
