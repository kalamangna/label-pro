<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('settings', true);
    }

    public function down()
    {
        // Re-create the table if rolled back
        $this->forge->addField([
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('key', true);
        $this->forge->createTable('settings');
    }
}
