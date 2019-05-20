<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Build a body of json response
     *
     * @param integer $status
     * @param array $results
     * @param array $errors
     * @return JsonResponse
     */
    protected function buildResponse($status, $results = [], $errors = []) : JsonResponse
    {
        $response = [
            'errors' => $errors,
            'results' => $results
        ];

        return response()->json($response, $status);
    }
}
