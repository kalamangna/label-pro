<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProjectIdToGuests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guests', [
            'project_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
        ]);
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('guests', 'guests_project_id_foreign');
        $this->forge->dropColumn('guests', 'project_id');
    }
}
