<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse(array $response = [], int $codeResponse, string $message = '')
    {
        return response()->json(
            [
                'success' => true,
                'message' => $message,
                'data'    => $response
            ],
            $codeResponse
        );
    }

    public function errorResponse(int $codeResponse = 500, string $message = '', array $response = [])
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message,
                'data'    => $response
            ],
            $codeResponse
        );
    }
}
