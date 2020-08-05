<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->respondNotFound('Game ID or Team abbreviation required.');
    }

    public function show(Request $request, $id)
    {
        $mode = $request->input('mode');

        if ($mode && $mode !== 'detailed') {
            return $this->respondNotFound('Valid modes are: detailed.');
        }

        if (is_numeric($id)) {
            $teams = (new Team)->where('gid', $id)->get();

            if (! $teams->count()) {
                return $this->respondNotFound('Game not found.');
            }
        } else {
            $count = $request->input('count') ?: 200;
            if ($count > 200) {
                $count = 200;
            }
            $start = $request->input('start') - 1;

            $teams = (new Team)->where('tname', $id)->take($count)->skip($start)->get();

            if (! $teams->count()) {
                return $this->respondNotFound('Team not found.');
            }
        }

        if ($mode === 'detailed') {
            foreach ($teams as $row) {
                $gid = $row->gid;
                $game_details = (new Game)->where('gid', $gid)->first();
                unset($game_details['gid']);
                $row->game_details = $game_details;
            }
        }

        return $this->respond([
            'data' => $teams->toArray(),
        ]);
    }
}
