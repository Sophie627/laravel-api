<?php

namespace App\Http\Controllers;

use App\Models\Defense;
use Illuminate\Http\JsonResponse;

class DefenseController extends ApiController
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
        $defense = (new Defense)->where('gid', $id)->get();

        if (! $defense) {
            return $this->respondNotFound('Game not found.');
        }

        return $this->respond([
            'data' => $defense->toArray(),
        ]);
    }
}
