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
            'keys' => 'required|array|max:2|min:1',
            'values' => 'required|array|max:2|min:1',
            'keys.*' => 'max:255',
            'values.*' => 'version_object_value',
        ], [], [
            'keys' => "key",
            'values' => "value",
            'keys.*' => "key",
            'values.*' => "value",
        ]);

        if ($validator->fails())
            return APIResponse::abortValidator($validator);

        $list = request()->post();
        $finalResult = [];

        foreach ($list as $k => $v) {
            $temp = [];
            $temp[$k] = $v;

            $versionObject = VersionObject::generate($temp);
            $finalResult[] = $versionObject->getData();
        }

        return APIResponse::send($finalResult);
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
