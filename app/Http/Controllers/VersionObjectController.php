<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\VersionObject;

class VersionObjectController extends Controller
{


    public function index()
    {
        $versionObjects = [];

        foreach (VersionObject::all() as $vo)
            $versionObjects[] = $vo->getData();

        return response()->json([
            "message" => "",
            "data" => $versionObjects,
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make([
            "keys" => array_keys($request->all()),
            "values" => array_values($request->all()),
        ], [
            'keys' => 'required|array|max:1|min:1',
            'keys.*' => 'required',
            'values.*' => 'required',
        ]);

        //TODO. Length of keys and values.
        //TODO. validation if array or string
        //TODO. {"111" : []}
        //TODO. empty string value

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->getMessages()], 422);
        }

        $list = request()->post();
        $versionObject = VersionObject::generate($list);

        if (!$versionObject) {
            return response()->json(["message" => "Page Not Found"], 404);
        }

        return response()->json([
            "message" => "",
            "data" => $versionObject->getData(),
        ]);
    }

    public function show(Request $request, $key)
    {
        $validator = \Validator::make($request->all(), [
            'timestamp' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->getMessages()], 422);
        }

        $timestamp = request()->get("timestamp");

        $versionObject = VersionObject::search($key, $timestamp);

        //TODO. timestamp should be timestamp

        if (!$versionObject) {
            return response()->json(["message" => "Page Not Found"], 404);
        }

        return response()->json([
            "message" => "",
            "data" => $versionObject->getData(),
        ]);
    }

}
