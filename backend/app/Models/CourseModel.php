<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'description', 'start_date', 'end_date',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'description' => 'permit_empty|max_length[500]',
        'start_date' => 'required|valid_date',
        'end_date' => 'required|valid_date|check_end_date[start_date]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'O nome do curso é obrigatório.',
            'min_length' => 'O nome do curso deve ter pelo menos 3 caracteres.',
            'max_length' => 'O nome do curso não pode exceder 255 caracteres.',
        ],
        'description' => [
            'max_length' => 'A descrição não pode exceder 500 caracteres.',
        ],
        'start_date' => [
            'required' => 'A data de início é obrigatória.',
            'valid_date' => 'A data de início deve ser uma data válida.',
        ],
        'end_date' => [
            'required' => 'A data de término é obrigatória.',
            'valid_date' => 'A data de término deve ser uma data válida.',
            'check_end_date' => 'A data de término deve ser posterior à data de início.',
        ],
    ];
}
