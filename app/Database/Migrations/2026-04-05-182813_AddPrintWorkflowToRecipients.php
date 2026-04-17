<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPrintWorkflowToGuests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guests', [
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
        $this->forge->dropColumn('guests', ['is_selected', 'is_printed']);
    }
}
