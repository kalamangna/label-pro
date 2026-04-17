<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToGuests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guests', [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('guests', 'user_id');
    }
}
