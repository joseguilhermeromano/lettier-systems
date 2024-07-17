<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('CourseSeeder');
        $this->call('AddressSeeder');
        $this->call('TeacherSeeder');
        $this->call('ClassSeeder');
        $this->call('GuardianSeeder');
        $this->call('StudentSeeder');
    }
}
