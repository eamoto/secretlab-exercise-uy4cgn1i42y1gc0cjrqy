<?php
namespace App\Helpers;

class APIResponse
{
    public static function abort404($msg = "The resources was not found.")
    {
        return response()->json(self::generate(null, $msg), 404);
    }

    public static function abortValidator($validator)
    {
        return response()->json(
            self::generate(null, array_merge(...array_values($validator->errors()->getMessages()))),
            422
        );
    }

    //public static function abort($msg = "Something went wrong.", $code = 500)
    //{
    //    return response()->json(self::generate(null, $msg), $code);
    //}

    public static function send($data = [], $msg = null, $code = 200)
    {
        return response()->json(self::generate($data, $msg), $code);
    }

    public static function generate($data = null, $msg = null)
    {
        if ($msg === null)
            $msg = [];

        if (!is_array($msg))
            $msg = [$msg];

        $result = [
            "messages" => $msg
        ];

        if ($data !== null)
            $result["data"] = $data;

        return $result;
    }
}
