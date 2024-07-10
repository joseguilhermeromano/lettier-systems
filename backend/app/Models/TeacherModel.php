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

    public function address()
    {
        return $this->belongsTo(AddressModel::class, 'address_id');
    }
}
