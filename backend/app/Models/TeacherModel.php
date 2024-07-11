<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email', 'phone_number', 'image', 'address_id',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'email' => 'required|valid_email|max_length[255]',
        'phone_number' => 'required|regex_match[/^\+?[0-9]{10,15}$/]',
        'image' => 'permit_empty|valid_url|max_length[255]',
        'address_id' => 'required|is_natural_no_zero'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'O nome é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
            'max_length' => 'O nome não pode exceder 255 caracteres.',
        ],
        'email' => [
            'required' => 'O e-mail é obrigatório.',
            'valid_email' => 'O e-mail deve ser válido.',
            'max_length' => 'O e-mail não pode exceder 255 caracteres.',
        ],
        'phone_number' => [
            'required' => 'O número de telefone é obrigatório.',
            'regex_match' => 'O número de telefone deve ser válido e incluir o código do país.',
        ],
        'image' => [
            'valid_url' => 'A imagem deve ser uma URL válida.',
            'max_length' => 'A URL da imagem não pode exceder 255 caracteres.',
        ],
        'address_id' => [
            'required' => 'O ID do endereço é obrigatório.',
            'is_natural_no_zero' => 'O ID do endereço deve ser um número natural não nulo.',
        ],
    ];

    public function address()
    {
        return $this->belongsTo(AddressModel::class, 'address_id');
    }
}
