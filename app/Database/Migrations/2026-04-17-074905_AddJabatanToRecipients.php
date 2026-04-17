<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJabatanToRecipients extends Migration
{
    public function up()
    {
        $this->forge->addColumn('recipients', [
            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('recipients', 'jabatan');
    }
}
