<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToRecipients extends Migration
{
    public function up()
    {
        $this->forge->addColumn('recipients', [
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
        $this->forge->dropColumn('recipients', 'user_id');
    }
}
