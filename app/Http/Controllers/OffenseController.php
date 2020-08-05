<?php

namespace App\Http\Controllers;

use App\Models\Offense;
use Illuminate\Http\JsonResponse;

class OffenseController extends ApiController
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
        $offense = (new Offense)->where('gid', $id)->get();

        if (! $offense->count()) {
            return $this->respondNotFound('Game not found.');
        }

        return $this->respond([
            'data' => $offense->toArray(),
        ]);
    }
}
