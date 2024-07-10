<?php

namespace App\Models;

use CodeIgniter\Model;

class GuardianModel extends Model
{
    protected $table = 'guardians';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'email', 'phone_number', 'relationship', 'image', 'address_id',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;

    public function address()
    {
        return $this->belongsTo(AddressModel::class, 'address_id');
    }
}
