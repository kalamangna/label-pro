<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIgnoreDuplicateToGuests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guests', [
            'ignore_duplicate' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('guests', 'ignore_duplicate');
    }
}
