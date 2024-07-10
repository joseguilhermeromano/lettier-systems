<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClassesTable extends Migration
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
                'constraint' => '100',
            ],
            'teacher_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'course_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'start_time' => [
                'type'       => 'TIME',
            ],
            'end_time' => [
                'type'       => 'TIME',
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
        $this->forge->addForeignKey('teacher_id', 'teachers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('classes');
    }

    public function down()
    {
        $this->forge->dropTable('classes');
    }
}
