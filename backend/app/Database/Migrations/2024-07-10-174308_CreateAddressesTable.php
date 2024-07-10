<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'street' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'neighborhood' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'number' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'zipcode' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP',
                'null'       => true,
                'default'    => null,
            ],
            'updated_at' => [
                'type'       => 'TIMESTAMP',
                'null'       => true,
                'default'    => null,
                'on_update'  => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('addresses');
    }

    public function down()
    {
        $this->forge->dropTable('addresses');
    }
}
