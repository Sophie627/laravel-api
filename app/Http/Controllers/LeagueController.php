<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\JsonResponse;

class LeagueController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $league = League::all();

        return $this->respond([
            'data' => $league->toArray(),
        ]);
    }
}
