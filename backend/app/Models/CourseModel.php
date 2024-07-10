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
}
