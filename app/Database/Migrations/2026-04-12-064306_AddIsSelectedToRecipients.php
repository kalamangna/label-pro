<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsSelectedToGuests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guests', [
            'is_selected' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('guests', 'is_selected');
    }
}
