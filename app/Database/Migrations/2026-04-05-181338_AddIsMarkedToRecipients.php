<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsMarkedToGuests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guests', [
            'is_marked' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('guests', 'is_marked');
    }
}
