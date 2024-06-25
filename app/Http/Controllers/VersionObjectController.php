<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\VersionObject;
use App\Helpers\APIResponse;

class VersionObjectController extends Controller
{
    public function index()
    {
        $versionObjects = [];

        foreach (VersionObject::all() as $vo)
            $versionObjects[] = $vo->getData();

        return APIResponse::send($versionObjects);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make([
            "keys" => array_keys($request->all()),
            "values" => array_values($request->all()),
        ], [
            'keys' => 'required|array|max:1|min:1',
            'values' => 'required|array|max:1|min:1',
            'keys.0' => 'max:255',
            'values.0' => 'version_object_value',
        ], [], [
            'keys' => "key",
            'values' => "value",
            'keys.0' => "key",
            'values.0' => "value",
        ]);

        if ($validator->fails())
            return APIResponse::abortValidator($validator);

        $list = request()->post();
        $versionObject = VersionObject::generate($list);

        return APIResponse::send($versionObject->getData());
    }

    public function show(Request $request, $key)
    {
        $validator = \Validator::make($request->all(), [
            'timestamp' => 'nullable|integer',
        ]);

        if ($validator->fails())
            return APIResponse::abortValidator($validator);

        $timestamp = request()->get("timestamp");
        $versionObject = VersionObject::lookUp($key, $timestamp);

        if (!$versionObject)
            return APIResponse::abort404();

        return APIResponse::send($versionObject->getData());
    }
}
