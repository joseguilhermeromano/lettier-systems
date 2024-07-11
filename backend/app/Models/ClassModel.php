<?php

namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'teacher_id', 'course_id', 'start_time', 'end_time',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'teacher_id' => 'required|is_natural_no_zero',
        'course_id' => 'required|is_natural_no_zero',
        'start_time' => 'required',
        'end_time' => 'required',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'O nome da turma é obrigatório.',
            'min_length' => 'O nome da turma deve ter pelo menos 3 caracteres.',
            'max_length' => 'O nome da turma não pode exceder 255 caracteres.',
        ],
        'teacher_id' => [
            'required' => 'O ID do professor é obrigatório.',
            'is_natural_no_zero' => 'O ID do professor deve ser um número natural não nulo.',
        ],
        'course_id' => [
            'required' => 'O ID do curso é obrigatório.',
            'is_natural_no_zero' => 'O ID do curso deve ser um número natural não nulo.',
        ],
        'start_time' => [
            'required' => 'O horário de início é obrigatório.',
        ],
        'end_time' => [
            'required' => 'O horário de término é obrigatório.',
        ],
    ];

    protected $beforeInsert = ['validateTimes'];
    protected $beforeUpdate = ['validateTimes'];

    protected function validateTimes(array $data)
    {
        if (isset($data['data']['start_time']) && isset($data['data']['end_time'])) {
            if (strtotime($data['data']['end_time']) <= strtotime($data['data']['start_time'])) {
                $this->validationMessages['end_time']['check_end_time'] = 'O horário de término deve ser posterior ao horário de início.';
                return false;
            }
        }
        return $data;
    }

    public function teacher()
    {
        return $this->belongsTo(TeacherModel::class, 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(CourseModel::class, 'course_id');
    }
}
