<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email', 'cpf', 'birthday', 'gender', 'phone_number', 'image', 'address_id', 'class_id',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;

    public function address()
    {
        return $this->belongsTo(AddressModel::class, 'address_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
