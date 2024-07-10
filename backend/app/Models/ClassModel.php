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

    public function teacher()
    {
        return $this->belongsTo(TeacherModel::class, 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(CourseModel::class, 'course_id');
    }
}
