<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Chart;
use App\Models\Conv;
use App\Models\Defense;
use App\Models\Drive;
use App\Models\Fgxp;
use App\Models\Fumble;
use App\Models\Game;
use App\Models\Injury;
use App\Models\Intercpt;
use App\Models\Kicker;
use App\Models\Koff;
use App\Models\Offense;
use App\Models\Pass;
use App\Models\PBP;
use App\Models\Penalty;
use App\Models\Play;
use App\Models\Player;
use App\Models\Punt;
use App\Models\Redzone;
use App\Models\Rush;
use App\Models\Sack;
use App\Models\Safety;
use App\Models\Snap;
use App\Models\Tackle;
use App\Models\Team;
use App\Models\Touchdown;
use App\Transformers\ChartTransformer;
use App\Transformers\DriveTransformer;
use App\Transformers\InjuryTransformer;
use App\Transformers\KickerTransformer;
use App\Transformers\Pass2Transformer;
use App\Transformers\PassTransformer;
use App\Transformers\TouchdownTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GamesController extends ApiController
{
    protected $chartTransformer;
    protected $driveTransformer;
    protected $injuryTransformer;
    protected $kickerTransformer;
    protected $passTransformer;
    protected $pass2Transformer;
    protected $touchdownTransformer;

    public function __construct(
        ChartTransformer $chartTransformer,
        DriveTransformer $driveTransformer,
        InjuryTransformer $injuryTransformer,
        KickerTransformer $kickerTransformer,
        PassTransformer $passTransformer,
        Pass2Transformer $pass2Transformer,
        TouchdownTransformer $touchdownTransformer
    ) {
        $this->chartTransformer = $chartTransformer;
        $this->driveTransformer = $driveTransformer;
        $this->injuryTransformer = $injuryTransformer;
        $this->kickerTransformer = $kickerTransformer;
        $this->passTransformer = $passTransformer;
        $this->pass2Transformer = $pass2Transformer;
        $this->touchdownTransformer = $touchdownTransformer;
    }

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

        $games = (new Game)->take($count)->skip($start)->get();

        return $this->respond([
            'data' => $games->toArray(),
        ]);
    }

    public function show($id)
    {
        if (is_numeric($id)) {
            $games = (new Game)->where('seas', $id)->get();

            if (! $games->count()) {
                return $this->respondNotFound('Season not found.');
            }
        } else {
            $games = (new Game)->where('v', $id)->orWhere('h', $id)->get();

            if (! $games->count()) {
                return $this->respondNotFound('Team not found.');
            }
        }

        return $this->respond([
            'data' => $games->toArray(),
        ]);
    }

    public function defense(Request $request, $id)
    {
        $first = (new Game)->where('seas', $id)->value('gid');

        if (! $first) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $last = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $defense = (new Defense)->where('gid', '>=', $first)->where('gid', '<=', $last)->take($count)->skip($start)->get();

        return $this->respond([
            'data' => $defense->toArray(),
        ]);
    }

    public function drives(Request $request, $id)
    {
        $first = (new Game)->where('seas', $id)->value('gid');

        if (! $first) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $last = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $drives = (new Drive)->where('gid', '>=', $first)->where('gid', '<=', $last)->take($count)->skip($start)->get();

        return $this->respond([
            'data' => $this->driveTransformer->transformCollection($drives->toArray()),
        ]);
    }

    public function kickers(Request $request, $id)
    {
        $first = (new Game)->where('seas', $id)->value('gid');

        if (! $first) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $last = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $kickers = (new Kicker)->where('gid', '>=', $first)->where('gid', '<=', $last)->take($count)->skip($start)->get();

        return $this->respond([
            'data' => $this->kickerTransformer->transformCollection($kickers->toArray()),
        ]);
    }

    public function snaps(Request $request, $id)
    {
        $first = (new Game)->where('seas', $id)->value('gid');

        if (! $first) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $last = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $snaps = (new Snap)->where('gid', '>=', $first)->where('gid', '<=', $last)->take($count)->skip($start)->get();

        return $this->respond([
            'data' => $snaps->toArray(),
        ]);
    }

    public function offense(Request $request, $id)
    {
        $first = (new Game)->where('seas', $id)->value('gid');

        if (! $first) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $last = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $offense = (new Offense)->where('gid', '>=', $first)->where('gid', '<=', $last)->take($count)->skip($start)->get();

        return $this->respond([
            'data' => $offense->toArray(),
        ]);
    }

    public function plays(Request $request, $id)
    {
        $first = (new Game)->where('seas', $id)->value('gid');

        if (! $first) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $last = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $mode = $request->input('mode');
        $player = $request->input('player');

        // Check for valid mode if specified
        if ($mode && $mode !== 'flat' && $mode !== 'expanded') {
            return $this->respondNotFound('Valid modes are: flat, expanded.');
        }

        // Check for valid player if specified
        if ($player) {
            $result = (new Player)->where('player', $player)->first();

            if (! $result) {
                return $this->respondNotFound('Player not found.');
            }
        }

        // Queries with a player must use flat mode
        if ($player && (! $mode || ($mode && $mode !== 'flat'))) {
            return $this->respondNotFound('When specifying a player, set mode=flat');
        }

        if (! $mode) {
            $plays = (new Play)->where('gid', '>=', $first)->where('gid', '<=', $last)->take($count)->skip($start)->get();

            return $this->respond([
                'data' => $plays->toArray(),
            ]);
        }

        if ($mode === 'flat') {
            if (! $player) {
                $plays = (new PBP)->where('gid', '>=', $first)->where('gid', '<=', $last)->take($count)->skip($start)->get();
            }

            if ($player) {
                $plays = (new PBP)->where('gid', '>=', $first)->where('gid', '<=', $last)->when($player, function ($query) use ($player) {
                    return $query->where('bc', $player)->orWhere('rtck1', $player)->orWhere('rtck2', $player)->orWhere('psr', $player)->orWhere('trg', $player)
                        ->orWhere('dfb', $player)->orWhere('ptck1', $player)->orWhere('ptck2', $player)->orWhere('sk1', $player)->orWhere('sk2', $player)
                        ->orWhere('pen1', $player)->orWhere('pen2', $player)->orWhere('pen3', $player)->orWhere('ints', $player)->orWhere('fum', $player)
                        ->orWhere('frcv', $player)->orWhere('forc', $player)->orWhere('saf', $player)->orWhere('blk', $player)->orWhere('brcv', $player)
                        ->orWhere('fkicker', $player)->orWhere('punter', $player)->orWhere('pr', $player)->orWhere('kicker', $player)->orWhere('kr', $player);
                })->take($count)->skip($start)->get();
            }

            return $this->respond([
                'data' => $plays->toArray(),
            ]);
        }

        if ($mode === 'expanded') {
            global $detail;

            $plays = (new Play)->where('gid', '>=', $first)->where('gid', '<=', $last)->take($count)->skip($start)->get();

            foreach ($plays as $play) {
                $pid = $play->pid;
                $gid = $play->gid;

                if ($play->type !== 'NOPL') {
                    switch ($play->type) {
                        case 'RUSH':
                            $detail = (new Rush)->where('pid', $pid)->first();
                            break;
                        case 'PASS':
                            if (! $play->sk) {
                                $detail = (new Pass)->where('pid', $pid)->first();
                            }
                            break;
                        case 'PUNT':
                            $detail = (new Punt)->where('pid', $pid)->first();
                            break;
                        case 'KOFF':
                            $detail = (new Koff)->where('pid', $pid)->first();
                            break;
                        case 'FGXP':
                            $detail = (new Fgxp)->where('pid', $pid)->first();
                            break;
                        case 'CONV':
                            $detail = (new Conv)->where('pid', $pid)->first();
                    }

                    if ($detail) {
                        unset($detail->pid);

                        if ($play->type === 'PASS') {
                            $play->pass = $this->pass2Transformer->transform($detail);
                        } else {
                            $play[strtolower($play->type)] = $detail->toArray();
                        }
                    }
                }

                if ($play->tck) {
                    $tck = (new Tackle)->where('pid', '=', $pid)->get(); // Could be more than 1 tackler
                    for ($i = 0; $i < count($tck); $i++) {
                        unset($tck[$i]['pid']);
                    }
                    $play->tck = $tck->toArray();
                }

                if ($play->sk) {
                    $sk = (new Sack)->where('pid', '=', $pid)->get(); // Could be more than 1 player in on the sack
                    for ($i = 0; $i < count($sk); $i++) {
                        unset($sk[$i]['pid']);
                    }
                    $play->sk = $sk->toArray();
                }

                if ($play->pen) {
                    $pen = (new Penalty)->where('pid', '=', $pid)->get(); // Could be more than 1 penalty on a play
                    for ($i = 0; $i < count($pen); $i++) {
                        unset($pen[$i]['pid']);
                    }
                    $play->pen = $pen->toArray();
                }

                if ($play->ints) {
                    $int = (new Intercpt)->where('pid', $pid)->first();
                    unset($int['pid']);
                    $play->ints = $int;
                }

                if ($play->fum) {
                    $fum = (new Fumble)->where('pid', $pid)->first();
                    unset($fum['pid']);
                    $play->fum = $fum;
                }

                if ($play->saf) {
                    $saf = (new Safety)->where('pid', $pid)->first();
                    unset($saf['pid']);
                    $play->saf = $saf;
                }

                if ($play->blk) {
                    $blk = (new Block)->where('pid', $pid)->first();
                    unset($blk['pid']);
                    $play->blk = $blk;
                }

                $game = (new Game)->where('gid', $gid)->first();
                unset($game['gid']);
                $play->game = $game;
            }

            return $this->respond([
                'data' => $plays->toArray(),
            ]);
        }
    }

    public function redzone(Request $request, $id)
    {
        $first = (new Game)->where('seas', $id)->value('gid');

        if (! $first) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $last = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $redzone = (new Redzone)->where('gid', '>=', $first)->where('gid', '<=', $last)->take($count)->skip($start)->get();

        return $this->respond([
            'data' => $redzone->toArray(),
        ]);
    }

    public function teams(Request $request, $id)
    {
        $first = (new Game)->where('seas', $id)->value('gid');

        if (! $first) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 200;
        if ($count > 200) {
            $count = 200;
        }
        $start = $request->input('start') - 1;

        $last = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $teams = (new Team)->where('gid', '>=', $first)->where('gid', '<=', $last)->take($count)->skip($start)->get();

        return $this->respond([
            'data' => $teams->toArray(),
        ]);
    }

    public function blocks(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $blocks = (new Block)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $blocks->count()) {
            return $this->respondNotFound('Blocks not found.');
        }

        return $this->respond([
            'data' => $blocks->toArray(),
        ]);
    }

    public function charts(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $charts = (new Chart)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $charts->count()) {
            return $this->respondNotFound('Play charting data is available from 2018 onwards.');
        }

        return $this->respond([
            'data' => $this->chartTransformer->transformCollection($charts->toArray()),
        ]);
    }

    public function conversions(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $conversions = (new Conv)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $conversions->count()) {
            return $this->respondNotFound('Conversions not found.');
        }

        return $this->respond([
            'data' => $conversions->toArray(),
        ]);
    }

    public function fgxps(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $fgxps = (new Fgxp)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $fgxps->count()) {
            return $this->respondNotFound('Field-goals/Extra-points not found.');
        }

        return $this->respond([
            'data' => $fgxps->toArray(),
        ]);
    }

    public function fumbles(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $fumbles = (new Fumble)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $fumbles->count()) {
            return $this->respondNotFound('Fumbles not found.');
        }

        return $this->respond([
            'data' => $fumbles->toArray(),
        ]);
    }

    public function injuries(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $injuries = (new Injury)->where('gid', '>=', $gidFirst)->where('gid', '<=', $gidLast)->take($count)->skip($start)->get();

        if (! $injuries->count()) {
            return $this->respondNotFound('Injuries not found (available from 2015 onwards)');
        }

        return $this->respond([
            'data' => $this->injuryTransformer->transformCollection($injuries->toArray()),
        ]);
    }

    public function interceptions(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $interceptions = (new Intercpt)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $interceptions->count()) {
            return $this->respondNotFound('Interceptions not found.');
        }

        return $this->respond([
            'data' => $interceptions->toArray(),
        ]);
    }

    public function kickoffs(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $kickoffs = (new Koff)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $kickoffs->count()) {
            return $this->respondNotFound('Kickoffs not found.');
        }

        return $this->respond([
            'data' => $kickoffs->toArray(),
        ]);
    }

    public function passing(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $passing = (new Pass)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $passing->count()) {
            return $this->respondNotFound('Passing plays not found.');
        }

        return $this->respond([
            'data' => $this->passTransformer->transformCollection($passing->toArray()),
        ]);
    }

    public function penalties(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $penalties = (new Penalty)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $penalties->count()) {
            return $this->respondNotFound('Penalties not found.');
        }

        return $this->respond([
            'data' => $penalties->toArray(),
        ]);
    }

    public function punts(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $punts = (new Punt)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $punts->count()) {
            return $this->respondNotFound('Punts not found.');
        }

        return $this->respond([
            'data' => $punts->toArray(),
        ]);
    }

    public function rushing(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $rushing = (new Rush)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $rushing->count()) {
            return $this->respondNotFound('Rushing plays not found.');
        }

        return $this->respond([
            'data' => $rushing->toArray(),
        ]);
    }

    public function sacks(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $sacks = (new Sack)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $sacks->count()) {
            return $this->respondNotFound('Sacks not found.');
        }

        return $this->respond([
            'data' => $sacks->toArray(),
        ]);
    }

    public function safeties(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $safeties = (new Safety)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $safeties->count()) {
            return $this->respondNotFound('Safeties not found.');
        }

        return $this->respond([
            'data' => $safeties->toArray(),
        ]);
    }

    public function tackles(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $tackles = (new Tackle)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $tackles->count()) {
            return $this->respondNotFound('Tackles not found.');
        }

        return $this->respond([
            'data' => $tackles->toArray(),
        ]);
    }

    public function touchdowns(Request $request, $id)
    {
        $gidFirst = (new Game)->where('seas', $id)->value('gid');

        if (! $gidFirst) {
            return $this->respondNotFound('Season not found.');
        }

        $count = $request->input('count') ?: 1000;
        if ($count > 1000) {
            $count = 1000;
        }
        $start = $request->input('start') - 1;

        $gidLast = (new Game)->orderBy('gid', 'DESC')->where('seas', $id)->value('gid');
        $pidFirst = (new Play)->where('gid', $gidFirst)->value('pid');
        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $gidLast)->value('pid');
        $touchdowns = (new Touchdown)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->take($count)->skip($start)->get();

        if (! $touchdowns->count()) {
            return $this->respondNotFound('Touchdowns not found.');
        }

        return $this->respond([
            'data' => $this->touchdownTransformer->transformCollection($touchdowns->toArray()),
        ]);
    }
}
