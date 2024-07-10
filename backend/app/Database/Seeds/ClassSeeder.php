<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Turma A',
                'teacher_id' => 1,
                'course_id' => 1,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Turma B',
                'teacher_id' => 2,
                'course_id' => 2,
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Turma C',
                'teacher_id' => 3,
                'course_id' => 3,
                'start_time' => '13:00:00',
                'end_time' => '15:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Turma D',
                'teacher_id' => 4,
                'course_id' => 4,
                'start_time' => '15:00:00',
                'end_time' => '17:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Turma E',
                'teacher_id' => 5,
                'course_id' => 5,
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Turma F',
                'teacher_id' => 6,
                'course_id' => 6,
                'start_time' => '11:00:00',
                'end_time' => '13:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Turma G',
                'teacher_id' => 7,
                'course_id' => 7,
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Turma H',
                'teacher_id' => 8,
                'course_id' => 8,
                'start_time' => '16:00:00',
                'end_time' => '18:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Turma I',
                'teacher_id' => 9,
                'course_id' => 9,
                'start_time' => '08:00:00',
                'end_time' => '10:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Turma J',
                'teacher_id' => 10,
                'course_id' => 10,
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        // Using Query Builder
        $this->db->table('classes')->insertBatch($data);
    }
}
