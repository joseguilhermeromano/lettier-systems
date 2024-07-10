<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'street', 'neighborhood', 'number', 'city', 'state', 'zipcode',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
}
