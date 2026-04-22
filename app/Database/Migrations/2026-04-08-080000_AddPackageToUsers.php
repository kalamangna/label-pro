<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPackageToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'package' => [
                'type'       => 'ENUM',
                'constraint' => ['basic', 'pro', 'unlimited'],
                'null'       => true,
                'default'    => null,
                'after'      => 'role',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'package');
    }
}
