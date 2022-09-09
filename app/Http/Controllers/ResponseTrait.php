<?php

namespace App\Http\Controllers;

trait ResponseTrait
{
    public function success($data = [], $message = '', $status = 200)
    {
        return response([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    public function failure($data = [], $message = '', $status = 422)
    {
        return response([
            'data' => $data,
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
