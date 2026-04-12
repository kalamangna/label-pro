<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsSelectedToRecipients extends Migration
{
    public function up()
    {
        $this->forge->addColumn('recipients', [
            'is_selected' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('recipients', 'is_selected');
    }
}
