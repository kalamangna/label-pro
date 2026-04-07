<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveIsSelectedFromRecipients extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('recipients', 'is_selected');
    }

    public function down()
    {
        $this->forge->addColumn('recipients', [
            'is_selected' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
        ]);
    }
}
