<?php
namespace App\Services;

class VersionObjectValidator
{
    public static function do($value = null)
    {
        if (!in_array(gettype($value), ["string", "array", "integer", "double", "NULL"]))
            return false;

        $stringValue = $value;

        if (is_string($value))
            $value = trim($value);

        if (is_array($value))
            $stringValue = json_encode($value);

        if ($value === "")
            return false;

        if (strlen($stringValue) >= 1000000)
            return false;

        return true;
    }
}
