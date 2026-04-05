<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
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

        // Insert default activation status
        $this->db->table('settings')->insert([
            'key'   => 'is_activated',
            'value' => '0',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
