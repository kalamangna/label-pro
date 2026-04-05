<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPrintWorkflowToRecipients extends Migration
{
    public function up()
    {
        $this->forge->addColumn('recipients', [
            'is_selected' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
            'is_printed' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('recipients', ['is_selected', 'is_printed']);
    }
}
