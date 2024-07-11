<?php

namespace App\Validation;

class CustomRules
{
    public function check_end_date(string $str, string $fields, array $data): bool
    {
        return strtotime($data['end_date']) > strtotime($data['start_date']);
    }
}
