<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayersController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;
        $mode = $request->input('mode');
        $status = $request->input('status');

        // Check for valid mode if specified
        if ($mode && $mode !== 'basic') {
            return $this->respondNotFound('Valid modes are: basic.');
        }

        if ($mode === 'basic') {
            if ($status === 'active') {
                $players = (new Player)->select('player', 'fname', 'lname', 'cteam')->where('cteam', '!=', 'INA')->get();
            } else {
                $players = (new Player)->select('player', 'fname', 'lname')->get();
            }
        }

        if (! $mode) {
            if ($status === 'active') {
                $players = (new Player)->where('cteam', '!=', 'INA')->take($count)->skip($start)->get();
            } else {
                $players = (new Player)->take($count)->skip($start)->get();
            }
        }

        return $this->respond([
            'data' => $players->toArray(),
        ]);
    }

    public function show($team)
    {
        $players = (new Player)->where('cteam', $team)->orWhere('cteam', $team."\r")->get();

        if (! $players->count()) {
            return $this->respondNotFound('Team not found.');
        }

        return $this->respond([
            'data' => $players->toArray(),
        ]);
    }
}
