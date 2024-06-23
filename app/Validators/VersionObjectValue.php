<?php
namespace App\Validators;

class VersionObjectValue
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        if (!in_array(gettype($value), ["string", "array", "object"]))
            return false;

        if (is_string($value))
            $value = trim($value);

        if ($value === "")
            return false;

        return true;
    }
}