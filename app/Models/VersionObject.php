<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Enums\VersionObjectStatus;

class VersionObject extends Model
{
    use HasFactory;

    protected $guarded = ['id']; //TODO? 

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

    public static function generate($pair)
    {
        $key = array_keys($pair);
        $value = array_values($pair);

        if (count($key) !== 1)
            return null;

        $key = $key[0];
        $value = $value[0];

        if (is_array($value))
            $value = json_encode($value);

        return VersionObject::create([
            'utc_timestamp' => \Carbon\Carbon::now("UTC")->timestamp,
            'key' => $key,
            'value' => $value,
            'status' => "active",
        ]);
    }

    public static function search($key, $timestamp)
    {
        //TODO. check if timestap

        $versionObject = VersionObject::where("key", $key);

        if ($timestamp) 
            $versionObject->where("utc_timestamp", $timestamp);

        return $versionObject
            ->orderBy("utc_timestamp", "desc")
            ->first();
    }
}
