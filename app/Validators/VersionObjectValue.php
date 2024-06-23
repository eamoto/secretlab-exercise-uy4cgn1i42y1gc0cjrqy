<?php
namespace App\Validators;

use App\Models\VersionObject;

class VersionObjectValue
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return VersionObject::validateValue($value);
    }
}