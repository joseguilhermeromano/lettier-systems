<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Curso de PHP Avançado',
                'description' => 'Aprenda PHP avançado com técnicas modernas e boas práticas.',
                'start_date' => '2023-01-15',
                'end_date' => '2023-06-15',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'JavaScript para Iniciantes',
                'description' => 'Curso básico de JavaScript para quem está começando.',
                'start_date' => '2023-02-01',
                'end_date' => '2023-04-30',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Desenvolvimento Full Stack',
                'description' => 'Curso completo de desenvolvimento web, do frontend ao backend.',
                'start_date' => '2023-03-01',
                'end_date' => '2023-09-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Introdução ao Machine Learning',
                'description' => 'Aprenda os fundamentos de Machine Learning com Python.',
                'start_date' => '2023-04-01',
                'end_date' => '2023-07-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Data Science com R',
                'description' => 'Curso de análise de dados e ciência de dados utilizando R.',
                'start_date' => '2023-05-01',
                'end_date' => '2023-08-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Desenvolvimento Mobile com Flutter',
                'description' => 'Curso de desenvolvimento de aplicativos móveis usando Flutter.',
                'start_date' => '2023-06-01',
                'end_date' => '2023-09-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'DevOps: Práticas e Ferramentas',
                'description' => 'Curso sobre práticas e ferramentas de DevOps.',
                'start_date' => '2023-07-01',
                'end_date' => '2023-10-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'UX/UI Design para Web',
                'description' => 'Curso de design de interfaces e experiência do usuário para web.',
                'start_date' => '2023-08-01',
                'end_date' => '2023-11-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Introdução ao Node.js',
                'description' => 'Curso básico de desenvolvimento backend com Node.js.',
                'start_date' => '2023-09-01',
                'end_date' => '2023-12-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'React.js para Iniciantes',
                'description' => 'Curso de desenvolvimento de interfaces com React.js.',
                'start_date' => '2023-10-01',
                'end_date' => '2024-01-01',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        // Using Query Builder
        $this->db->table('courses')->insertBatch($data);
    }
}
