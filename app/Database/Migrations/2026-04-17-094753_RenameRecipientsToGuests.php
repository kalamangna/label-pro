<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameGuestsToGuests extends Migration
{
    public function up()
    {
        $this->forge->renameTable('guests', 'guests');
    }

    public function down()
    {
        $this->forge->renameTable('guests', 'guests');
    }
}
