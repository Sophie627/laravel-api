<?php

namespace App\Http\Controllers;

use App\Models\Redzone;
use Illuminate\Http\JsonResponse;

class RedzoneController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->respondNotFound('Game ID required.');
    }

    public function show($id)
    {
        $redzone = (new Redzone)->where('gid', $id)->get();

        if (! $redzone->count()) {
            return $this->respondNotFound('Game not found.');
        }

        return $this->respond([
            'data' => $redzone->toArray(),
        ]);
    }
}
