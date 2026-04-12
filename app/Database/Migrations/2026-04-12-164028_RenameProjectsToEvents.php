<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameProjectsToEvents extends Migration
{
    public function up()
    {
        $this->forge->renameTable('projects', 'events');
        $this->forge->modifyColumn('recipients', [
            'project_id' => [
                'name' => 'event_id',
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->renameTable('events', 'projects');
        $this->forge->modifyColumn('recipients', [
            'event_id' => [
                'name' => 'project_id',
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
        ]);
    }
}
