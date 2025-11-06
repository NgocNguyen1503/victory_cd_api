<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = null)
    {
        return response()->json([
            'code'    => 200,
            'data'    => $data,
            'message' => 'Success.'
        ]);
    }

    public static function dataNotfound()
    {
        return response()->json([
            'code'    => 204,
            'data'    => null,
            'message' => 'Data not found.'
        ]);
    }

    public static function internalServerError($data = null)
    {
        return response()->json([
            'code'    => 500,
            'data'    => $data,
            'message' => 'Internal server error.'
        ]);
    }

    public static function unauthorized()
    {
        return response()->json([
            'code'    => 401,
            'data'    => null,
            'message' => 'Unauthorized.'
        ]);
    }

    public static function forbidden()
    {
        return response()->json([
            'code'    => 403,
            'data'    => null,
            'message' => 'Forbidden'
        ]);
    }

    public static function unprocessableEntity()
    {
        return response()->json([
            'code'    => 422,
            'data'    => null,
            'message' => 'Unprocessable Entity'
        ]);
    }
}
