<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJabatanToGuests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('guests', [
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
        $this->forge->dropColumn('guests', 'jabatan');
    }
}
