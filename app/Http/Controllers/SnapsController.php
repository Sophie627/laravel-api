<?php

namespace App\Http\Controllers;

use App\Models\Snap;
use Illuminate\Http\JsonResponse;

class SnapsController extends ApiController
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
        $snaps = (new Snap)->where('gid', $id)->get();

        if (! $snaps->count()) {
            return $this->respondNotFound('Game not found.');
        }

        return $this->respond([
            'data' => $snaps->toArray(),
        ]);
    }
}
