<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsMarkedToRecipients extends Migration
{
    public function up()
    {
        $this->forge->addColumn('recipients', [
            'is_marked' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('recipients', 'is_marked');
    }
}
