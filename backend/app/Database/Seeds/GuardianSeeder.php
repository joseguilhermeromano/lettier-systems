<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GuardianSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Carlos Silva',
                'email' => 'carlos.silva@example.com',
                'phone_number' => '11987654321',
                'relationship' => 'father',
                'image' => 'carlos_silva.png',
                'address_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Mariana Oliveira',
                'email' => 'mariana.oliveira@example.com',
                'phone_number' => '21987654321',
                'relationship' => 'mother',
                'image' => 'mariana_oliveira.png',
                'address_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'João Pereira',
                'email' => 'joao.pereira@example.com',
                'phone_number' => '31987654321',
                'relationship' => 'guardian',
                'image' => 'joao_pereira.png',
                'address_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Ana Souza',
                'email' => 'ana.souza@example.com',
                'phone_number' => '41987654321',
                'relationship' => 'mother',
                'image' => 'ana_souza.png',
                'address_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Pedro Santos',
                'email' => 'pedro.santos@example.com',
                'phone_number' => '51987654321',
                'relationship' => 'father',
                'image' => 'pedro_santos.png',
                'address_id' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Fernanda Costa',
                'email' => 'fernanda.costa@example.com',
                'phone_number' => '61987654321',
                'relationship' => 'guardian',
                'image' => 'fernanda_costa.png',
                'address_id' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Lucas Lima',
                'email' => 'lucas.lima@example.com',
                'phone_number' => '71987654321',
                'relationship' => 'father',
                'image' => 'lucas_lima.png',
                'address_id' => 7,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Paula Alves',
                'email' => 'paula.alves@example.com',
                'phone_number' => '81987654321',
                'relationship' => 'mother',
                'image' => 'paula_alves.png',
                'address_id' => 8,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Juliana Martins',
                'email' => 'juliana.martins@example.com',
                'phone_number' => '91987654321',
                'relationship' => 'guardian',
                'image' => 'juliana_martins.png',
                'address_id' => 9,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Roberto Gomes',
                'email' => 'roberto.gomes@example.com',
                'phone_number' => '21987654322',
                'relationship' => 'other',
                'image' => 'roberto_gomes.png',
                'address_id' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        // Using Query Builder
        $this->db->table('guardians')->insertBatch($data);
    }
}
