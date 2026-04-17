<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveIsSelectedFromGuests extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('guests', 'is_selected');
    }

    public function down()
    {
        $this->forge->addColumn('guests', [
            'is_selected' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
        ]);
    }
}
