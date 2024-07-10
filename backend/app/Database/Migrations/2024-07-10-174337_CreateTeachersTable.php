<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeachersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
                'null'       => true,
            ],
            'phone_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'address_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
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
        $this->forge->addForeignKey('address_id', 'addresses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('teachers');
    }

    public function down()
    {
        $this->forge->dropTable('teachers');
    }
}
