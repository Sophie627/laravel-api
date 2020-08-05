<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Chart;
use App\Models\Conv;
use App\Models\Defense;
use App\Models\Fgxp;
use App\Models\Fumble;
use App\Models\Game;
use App\Models\Injury;
use App\Models\Intercpt;
use App\Models\Kicker;
use App\Models\Koff;
use App\Models\Offense;
use App\Models\Pass;
use App\Models\Penalty;
use App\Models\Player;
use App\Models\Punt;
use App\Models\Redzone;
use App\Models\Rush;
use App\Models\Sack;
use App\Models\Safety;
use App\Models\Snap;
use App\Models\Tackle;
use App\Models\Touchdown;
use App\Transformers\ChartTransformer;
use App\Transformers\InjuryTransformer;
use App\Transformers\KickerTransformer;
use App\Transformers\PassTransformer;
use App\Transformers\TouchdownTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlayerController extends ApiController
{
    protected $chartTransformer;
    protected $injuryTransformer;
    protected $kickerTransformer;
    protected $passTransformer;
    protected $touchdownTransformer;

    public function __construct(
        ChartTransformer $chartTransformer,
        InjuryTransformer $injuryTransformer,
        KickerTransformer $kickerTransformer,
        PassTransformer $passTransformer,
        TouchdownTransformer $touchdownTransformer
    ) {
        $this->chartTransformer = $chartTransformer;
        $this->injuryTransformer = $injuryTransformer;
        $this->kickerTransformer = $kickerTransformer;
        $this->passTransformer = $passTransformer;
        $this->touchdownTransformer = $touchdownTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        if (strpos($id, '_') !== false) {
            $name = explode('_', $id);
            if (count($name) > 2) {
                $players = (new Player)->where('fname', ucfirst($name[0]))->where('lname', ucfirst($name[1]).' '.ucfirst($name[2]))->get();
            } else {
                $players = (new Player)->where('fname', ucfirst($name[0]))->where('lname', ucfirst($name[1]))->get();
            }

            if (! $players->count()) {
                return $this->respondNotFound('Player not found.');
            }

            return $this->respond([
                'data' => $players->toArray(),
            ]);
        }

        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        return $this->respond([
            'data' => $player,
        ]);
    }

    public function defense(Request $request, $id)
    {
        $mode = $request->input('mode');

        if ($mode && $mode !== 'detailed') {
            return $this->respondNotFound('Valid modes are: detailed.');
        }

        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $defense = (new Defense)->where('player', $id)->get();

        if (! $defense->count()) {
            return $this->respondNotFound('Defense Stats were not found for that player.');
        }

        if ($mode === 'detailed') {
            foreach ($defense as $row) {
                $player = $row->player;
                $gid = $row->gid;
                $player_details = (new Player)->where('player', $player)->first();
                $game_details = (new Game)->where('gid', $gid)->first();
                unset($player_details['player']);
                unset($player_details['cteam']);
                unset($player_details['posd']);
                unset($player_details['jnum']);
                unset($player_details['dcp']);
                unset($player_details['nflid']);
                unset($game_details['gid']);
                $row->player_details = $player_details;
                $row->game_details = $game_details;
            }
        }

        return $this->respond([
            'data' => $defense->toArray(),
        ]);
    }

    public function offense(Request $request, $id)
    {
        $mode = $request->input('mode');

        if ($mode && $mode !== 'detailed') {
            return $this->respondNotFound('Valid modes are: detailed.');
        }

        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $offense = (new Offense)->where('player', $id)->get();

        if (! $offense->count()) {
            return $this->respondNotFound('Offense stats were not found for that player.');
        }

        if ($mode === 'detailed') {
            foreach ($offense as $row) {
                $player = $row->player;
                $gid = $row->gid;
                $player_details = (new Player)->where('player', $player)->first();
                $game_details = (new Game)->where('gid', $gid)->first();
                unset($player_details['player']);
                unset($player_details['cteam']);
                unset($player_details['posd']);
                unset($player_details['jnum']);
                unset($player_details['dcp']);
                unset($player_details['nflid']);
                unset($game_details['gid']);
                $row->player_details = $player_details;
                $row->game_details = $game_details;
            }
        }

        return $this->respond([
            'data' => $offense->toArray(),
        ]);
    }

    public function kickers($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $kickers = (new Kicker)->where('player', $id)->get();

        if (! $kickers->count()) {
            return $this->respondNotFound('Kicker stats were not found for that player.');
        }

        return $this->respond([
            'data' => $this->kickerTransformer->transformCollection($kickers->toArray()),
        ]);
    }

    public function redzone($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $redzone = (new Redzone)->where('player', $id)->get();

        if (! $redzone->count()) {
            return $this->respondNotFound('Redzone stats were not found for that player.');
        }

        return $this->respond([
            'data' => $redzone->toArray(),
        ]);
    }

    public function blocks($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $blocks = (new Block)->where('blk', $id)->orWhere('brcv', $id)->get();

        if (! $blocks->count()) {
            return $this->respondNotFound('Blocks were not found for that player.');
        }

        return $this->respond([
            'data' => $blocks->toArray(),
        ]);
    }

    public function conversions($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $conversions = (new Conv)->where('bc', $id)->orWhere('psr', $id)->orWhere('trg', $id)->get();

        if (! $conversions->count()) {
            return $this->respondNotFound('Conversions were not found for that player.');
        }

        return $this->respond([
            'data' => $conversions->toArray(),
        ]);
    }

    public function fgxp($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $fgxp = (new Fgxp)->where('fkicker', $id)->get();

        if (! $fgxp->count()) {
            return $this->respondNotFound('Field goals / extra points were not found for that player.');
        }

        return $this->respond([
            'data' => $fgxp->toArray(),
        ]);
    }

    public function fumbles($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $fumbles = (new Fumble)->where('fum', $id)->orWhere('frcv', $id)->orWhere('forc', $id)->get();

        if (! $fumbles->count()) {
            return $this->respondNotFound('Fumbles were not found for that player.');
        }

        return $this->respond([
            'data' => $fumbles->toArray(),
        ]);
    }

    public function interceptions($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $interceptions = (new Intercpt)->where('psr', $id)->orWhere('ints', $id)->get();

        if (! $interceptions->count()) {
            return $this->respondNotFound('Interceptions were not found for that player.');
        }

        return $this->respond([
            'data' => $interceptions->toArray(),
        ]);
    }

    public function kickoffs($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $kickoffs = (new Koff)->where('kicker', $id)->orWhere('kr', $id)->get();

        if (! $kickoffs->count()) {
            return $this->respondNotFound('Kickoffs were not found for that player.');
        }

        return $this->respond([
            'data' => $kickoffs->toArray(),
        ]);
    }

    public function passing(Request $request, $id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        } else {
            $count = $request->input('count') ?: 1000;
            if ($count > 1000) {
                $count = 1000;
            }
            $start = $request->input('start') - 1;

            $passing = (new Pass)->whereRaw("(psr = '$id' OR trg = '$id' OR dfb = '$id')")->take($count)->skip($start)->get();

            if (! $passing->count()) {
                return $this->respondNotFound('Passing plays were not found for that player.');
            }
        }

        return $this->respond([
            'data' => $this->passTransformer->transformCollection($passing->toArray()),
        ]);
    }

    public function penalties($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $penalties = (new Penalty)->where('pen', $id)->get();

        if (! $penalties->count()) {
            return $this->respondNotFound('Penalties were not found for that player.');
        }

        return $this->respond([
            'data' => $penalties->toArray(),
        ]);
    }

    public function punts($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $punts = (new Punt)->where('punter', $id)->orWhere('pr', $id)->get();

        if (! $punts->count()) {
            return $this->respondNotFound('Punts were not found for that player.');
        }

        return $this->respond([
            'data' => $punts->toArray(),
        ]);
    }

    public function rushing($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $rushing = (new Rush)->where('bc', $id)->get();

        if (! $rushing->count()) {
            return $this->respondNotFound('Rushing plays were not found for that player.');
        }

        return $this->respond([
            'data' => $rushing->toArray(),
        ]);
    }

    public function sacks($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $sacks = (new Sack)->where('qb', $id)->orWhere('sk', $id)->get();

        if (! $sacks->count()) {
            return $this->respondNotFound('Sacks were not found for that player.');
        }

        return $this->respond([
            'data' => $sacks->toArray(),
        ]);
    }

    public function safeties($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $safeties = (new Safety)->where('saf', $id)->get();

        if (! $safeties->count()) {
            return $this->respondNotFound('Safeties were not found for that player.');
        }

        return $this->respond([
            'data' => $safeties->toArray(),
        ]);
    }

    public function tackles($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $tackles = (new Tackle)->where('tck', $id)->get();

        if (! $tackles->count()) {
            return $this->respondNotFound('Tackles were not found for that player.');
        }

        return $this->respond([
            'data' => $tackles->toArray(),
        ]);
    }

    public function touchdowns($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $touchdowns = (new Touchdown)->where('player', $id)->get();

        if (! $touchdowns->count()) {
            return $this->respondNotFound('Touchdowns were not found for that player.');
        }

        return $this->respond([
            'data' => $this->touchdownTransformer->transformCollection($touchdowns->toArray()),
        ]);
    }

    public function injuries($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $injuries = (new Injury)->where('player', $id)->get();

        if (! $injuries->count()) {
            return $this->respondNotFound('Injuries were not found for that player.');
        }

        return $this->respond([
            'data' => $this->injuryTransformer->transformCollection($injuries->toArray()),
        ]);
    }

    public function charts(Request $request, $id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        } else {
            $count = $request->input('count') ?: 1000;
            if ($count > 1000) {
                $count = 1000;
            }
            $start = $request->input('start') - 1;

            $charts = (new Chart)->whereRaw("(qb = '$id' OR trg = '$id' OR bc = '$id' OR defpr1 = '$id' OR defpr2 = '$id' OR defhi = '$id' OR defhu1 = '$id' OR defhu2 = '$id')")->take($count)->skip($start)->get();

            if (! $charts->count()) {
                return $this->respondNotFound('Charted plays were not found for that player.');
            }
        }

        return $this->respond([
            'data' => $this->chartTransformer->transformCollection($charts->toArray()),
        ]);
    }

    public function snaps($id)
    {
        $player = (new Player)->where('player', $id)->first();

        if (! $player) {
            return $this->respondNotFound('Player not found.');
        }

        $snaps = (new Snap)->where('player', $id)->get();

        if (! $snaps->count()) {
            return $this->respondNotFound('Snap counts were not found for that player.');
        }

        return $this->respond([
            'data' => $snaps->toArray(),
        ]);
    }
}
