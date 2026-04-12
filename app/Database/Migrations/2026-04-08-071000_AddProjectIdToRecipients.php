<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProjectIdToRecipients extends Migration
{
    public function up()
    {
        $this->forge->addColumn('recipients', [
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
        $this->forge->dropForeignKey('recipients', 'recipients_project_id_foreign');
        $this->forge->dropColumn('recipients', 'project_id');
    }
}
