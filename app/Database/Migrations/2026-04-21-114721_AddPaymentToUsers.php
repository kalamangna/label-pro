<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'payment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['belum', 'lunas'],
                'default'    => null,
                'null'       => true,
            ],
            'payment_proof' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['payment_status', 'payment_proof']);
    }
}
