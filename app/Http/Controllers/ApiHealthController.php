<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

final class ApiHealthController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => config('app.name', 'KiloWatts') . ' - API version 1.0 live.'
        ]);
    }
}
