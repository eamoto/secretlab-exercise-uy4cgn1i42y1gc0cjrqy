<?php
namespace App\Validators;

use App\Models\VersionObject;
use App\Services\VersionObjectValidator;

class VersionObjectValue
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return VersionObjectValidator::do($value);
    }
}