<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\VersionObjectStatus;
use App\Services\VersionObjectValidator;

class VersionObject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'utc_timestamp',
        'key',
        'value',
        'status',
    ];

    protected $casts = [
        'status' => VersionObjectStatus::class
    ];

    public function getData()
    {
        $value = json_decode($this->value, true);

        if ($value === null)
            $value = $this->value;

        return [
            "utc_timestamp" => $this->utc_timestamp,
            "key" => $this->key,
            "value" => $value,
        ];
    }

    public static function generate($pair = null)
    {
        if (!is_array($pair))
            return null;

        $key = array_keys($pair);
        $value = array_values($pair);

        if (count($key) !== 1)
            return null;

        $key = $key[0];
        $value = $value[0];

        if (!VersionObjectValidator::do($value))
            return null;

        if (strlen($key) > 255)
            return null;

        if (is_array($value))
            $value = json_encode($value);

        return VersionObject::create([
            'utc_timestamp' => \Carbon\Carbon::now("UTC")->timestamp,
            'key' => $key,
            'value' => $value,
            'status' => "active",
        ]);
    }

    public static function lookUp($key = null, $timestamp = null)
    {
        if (!$key)
            return null;

        $versionObject = VersionObject::where("key", $key);

        if ($timestamp)
            $versionObject->where("utc_timestamp", '<=', $timestamp);

        return $versionObject
            ->orderBy("id", "desc")
            ->first();
    }

    /*
    public static function validateValue($value = null)
    {
        if (!in_array(gettype($value), ["string", "array", "integer", "double", "NULL" ]))
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
    */
}
