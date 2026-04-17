<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameProjectsToEvents extends Migration
{
    public function up()
    {
        $this->forge->renameTable('projects', 'events');
        $this->forge->modifyColumn('guests', [
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
        $this->forge->modifyColumn('guests', [
            'event_id' => [
                'name' => 'project_id',
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
        ]);
    }
}
