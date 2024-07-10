<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'street' => 'Rua das Flores',
                'neighborhood' => 'Centro',
                'number' => '123',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zipcode' => '01000-000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'street' => 'Avenida Paulista',
                'neighborhood' => 'Bela Vista',
                'number' => '456',
                'city' => 'São Paulo',
                'state' => 'SP',
                'zipcode' => '01310-000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'street' => 'Rua XV de Novembro',
                'neighborhood' => 'Centro',
                'number' => '789',
                'city' => 'Curitiba',
                'state' => 'PR',
                'zipcode' => '80020-310',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'street' => 'Avenida Rio Branco',
                'neighborhood' => 'Centro',
                'number' => '101',
                'city' => 'Rio de Janeiro',
                'state' => 'RJ',
                'zipcode' => '20040-007',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'street' => 'Rua dos Andradas',
                'neighborhood' => 'Centro',
                'number' => '202',
                'city' => 'Porto Alegre',
                'state' => 'RS',
                'zipcode' => '90020-000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'street' => 'Avenida Sete de Setembro',
                'neighborhood' => 'Centro',
                'number' => '303',
                'city' => 'Salvador',
                'state' => 'BA',
                'zipcode' => '40060-001',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'street' => 'Rua Conselheiro Mafra',
                'neighborhood' => 'Centro',
                'number' => '404',
                'city' => 'Florianópolis',
                'state' => 'SC',
                'zipcode' => '88010-000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'street' => 'Rua da Praia',
                'neighborhood' => 'Centro',
                'number' => '505',
                'city' => 'Fortaleza',
                'state' => 'CE',
                'zipcode' => '60060-000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'street' => 'Rua Barão do Rio Branco',
                'neighborhood' => 'Centro',
                'number' => '606',
                'city' => 'Brasília',
                'state' => 'DF',
                'zipcode' => '70040-000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'street' => 'Rua Gonçalves Dias',
                'neighborhood' => 'Centro',
                'number' => '707',
                'city' => 'Belo Horizonte',
                'state' => 'MG',
                'zipcode' => '30140-090',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        // Using Query Builder
        $this->db->table('addresses')->insertBatch($data);
    }
}
