<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Alice Silva',
                'email' => 'alice.silva@example.com',
                'cpf' => '12345678901',
                'birthday' => '2000-01-01',
                'gender' => 'female',
                'phone_number' => '11987654321',
                'image' => 'alice_silva.png',
                'address_id' => 1,
                'class_id' => 1,
                'guardian_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Bruno Oliveira',
                'email' => 'bruno.oliveira@example.com',
                'cpf' => '23456789012',
                'birthday' => '1999-02-02',
                'gender' => 'male',
                'phone_number' => '21987654321',
                'image' => 'bruno_oliveira.png',
                'address_id' => 2,
                'class_id' => 2,
                'guardian_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Carla Pereira',
                'email' => 'carla.pereira@example.com',
                'cpf' => '34567890123',
                'birthday' => '1998-03-03',
                'gender' => 'female',
                'phone_number' => '31987654321',
                'image' => 'carla_pereira.png',
                'address_id' => 3,
                'class_id' => 3,
                'guardian_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Diego Souza',
                'email' => 'diego.souza@example.com',
                'cpf' => '45678901234',
                'birthday' => '1997-04-04',
                'gender' => 'male',
                'phone_number' => '41987654321',
                'image' => 'diego_souza.png',
                'address_id' => 4,
                'class_id' => 4,
                'guardian_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Eduarda Santos',
                'email' => 'eduarda.santos@example.com',
                'cpf' => '56789012345',
                'birthday' => '1996-05-05',
                'gender' => 'female',
                'phone_number' => '51987654321',
                'image' => 'eduarda_santos.png',
                'address_id' => 5,
                'class_id' => 5,
                'guardian_id' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Fabio Lima',
                'email' => 'fabio.lima@example.com',
                'cpf' => '67890123456',
                'birthday' => '1995-06-06',
                'gender' => 'male',
                'phone_number' => '61987654321',
                'image' => 'fabio_lima.png',
                'address_id' => 6,
                'class_id' => 6,
                'guardian_id' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Gabriela Costa',
                'email' => 'gabriela.costa@example.com',
                'cpf' => '78901234567',
                'birthday' => '1994-07-07',
                'gender' => 'female',
                'phone_number' => '71987654321',
                'image' => 'gabriela_costa.png',
                'address_id' => 7,
                'class_id' => 7,
                'guardian_id' => 7,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Henrique Alves',
                'email' => 'henrique.alves@example.com',
                'cpf' => '89012345678',
                'birthday' => '1993-08-08',
                'gender' => 'male',
                'phone_number' => '81987654321',
                'image' => 'henrique_alves.png',
                'address_id' => 8,
                'class_id' => 8,
                'guardian_id' => 8,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Isabela Martins',
                'email' => 'isabela.martins@example.com',
                'cpf' => '90123456789',
                'birthday' => '1992-09-09',
                'gender' => 'female',
                'phone_number' => '91987654321',
                'image' => 'isabela_martins.png',
                'address_id' => 9,
                'class_id' => 9,
                'guardian_id' => 9,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'João Gomes',
                'email' => 'joao.gomes@example.com',
                'cpf' => '01234567890',
                'birthday' => '1991-10-10',
                'gender' => 'male',
                'phone_number' => '21987654322',
                'image' => 'joao_gomes.png',
                'address_id' => 10,
                'class_id' => 10,
                'guardian_id' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        // Using Query Builder
        $this->db->table('students')->insertBatch($data);
    }
}
