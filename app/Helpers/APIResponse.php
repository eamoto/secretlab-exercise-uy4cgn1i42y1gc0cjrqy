<?php
namespace App\Helpers;

class APIResponse
{
    public static function abort404($msg = null)
    {
        if (!$msg)
            $msg = "Page Not Found.";

        return response()->json(["messages" => [$msg]], 404);
    }

    public static function abortValidation($validator)
    {
        return response()->json([
            "messages" => array_merge(...array_values($validator->errors()->getMessages()))
        ], 404);
    }

    public static function abort($msg = null, $code = 500)
    {
        if (!$msg)
            $msg = ["Something went wrong. Please try again later."];

        if (!is_array($msg))
            $msg = [$msg];

        return response()->json(["messages" => $msg], $code);
    }

    public static function send($data = [], $msg = null, $code = 200)
    {
        if ($msg === null)
            $msg = [];

        if (!is_array($msg))
            $msg = [$msg];

        return response()->json(["messages" => $msg, "data" => $data], $code);
    }
}
