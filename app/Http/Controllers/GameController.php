<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Chart;
use App\Models\Conv;
use App\Models\Fgxp;
use App\Models\Fumble;
use App\Models\Game;
use App\Models\Injury;
use App\Models\Intercpt;
use App\Models\Koff;
use App\Models\Pass;
use App\Models\Penalty;
use App\Models\Play;
use App\Models\Punt;
use App\Models\Rush;
use App\Models\Sack;
use App\Models\Safety;
use App\Models\Snap;
use App\Models\Tackle;
use App\Models\Touchdown;
use App\Transformers\ChartTransformer;
use App\Transformers\DriveTransformer;
use App\Transformers\InjuryTransformer;
use App\Transformers\KickerTransformer;
use App\Transformers\Pass2Transformer;
use App\Transformers\PassTransformer;
use App\Transformers\TouchdownTransformer;
use Illuminate\Http\JsonResponse;

class GameController extends ApiController
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
     * @return JsonResponse
     */
    public function index()
    {
        return $this->respondNotFound('Game ID required.');
    }

    public function show($id)
    {
        $game = (new Game)->where('gid', $id)->first();

        if (! $game) {
            return $this->respondNotFound('Game not found.');
        }

        return $this->respond([
            'data' => $game->toArray(),
        ]);
    }

    public function blocks($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $blocks = (new Block)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $blocks) {
            return $this->respondNotFound('Blocks not found.');
        }

        return $this->respond([
            'data' => $blocks->toArray(),
        ]);
    }

    public function charts($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $charts = (new Chart)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $charts) {
            return $this->respondNotFound('Play charting data is available from 2018 onwards.');
        }

        return $this->respond([
            'data' => $this->chartTransformer->transformCollection($charts->toArray()),
        ]);
    }

    public function conversions($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $conversions = (new Conv)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $conversions) {
            return $this->respondNotFound('Conversions not found.');
        }

        return $this->respond([
            'data' => $conversions->toArray(),
        ]);
    }

    public function fgxps($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $fgxps = (new Fgxp)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $fgxps) {
            return $this->respondNotFound('Field-goals/Extra-points not found.');
        }

        return $this->respond([
            'data' => $fgxps->toArray(),
        ]);
    }

    public function fumbles($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $fumbles = (new Fumble)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $fumbles) {
            return $this->respondNotFound('Fumbles not found.');
        }

        return $this->respond([
            'data' => $fumbles->toArray(),
        ]);
    }

    public function injuries($id)
    {
        $injuries = (new Injury)->where('gid', $id)->get();

        if (! $injuries) {
            return $this->respondNotFound('Injuries not found.');
        }

        return $this->respond([
            'data' => $this->injuryTransformer->transformCollection($injuries->toArray()),
        ]);
    }

    public function interceptions($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $interceptions = (new Intercpt)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $interceptions) {
            return $this->respondNotFound('Interceptions not found.');
        }

        return $this->respond([
            'data' => $interceptions->toArray(),
        ]);
    }

    public function kickoffs($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $kickoffs = (new Koff)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $kickoffs) {
            return $this->respondNotFound('Kickoffs not found.');
        }

        return $this->respond([
            'data' => $kickoffs->toArray(),
        ]);
    }

    public function snaps($id)
    {
        $snaps = (new Snap)->where('gid', $id)->get();

        if (! $snaps) {
            return $this->respondNotFound('Snaps  not found.');
        }

        return $this->respond([
            'data' => $snaps->toArray(),
        ]);
    }

    public function passing($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $passing = (new Pass)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $passing) {
            return $this->respondNotFound('Passing plays not found.');
        }

        return $this->respond([
            'data' => $this->passTransformer->transformCollection($passing->toArray()),
        ]);
    }

    public function penalties($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $penalties = (new Penalty)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $penalties) {
            return $this->respondNotFound('Penalties not found.');
        }

        return $this->respond([
            'data' => $penalties->toArray(),
        ]);
    }

    public function punts($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $punts = (new Punt)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $punts) {
            return $this->respondNotFound('Punts not found.');
        }

        return $this->respond([
            'data' => $punts->toArray(),
        ]);
    }

    public function rushing($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $rushing = (new Rush)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $rushing) {
            return $this->respondNotFound('Rushing plays not found.');
        }

        return $this->respond([
            'data' => $rushing->toArray(),
        ]);
    }

    public function sacks($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $sacks = (new Sack)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $sacks) {
            return $this->respondNotFound('Sacks not found.');
        }

        return $this->respond([
            'data' => $sacks->toArray(),
        ]);
    }

    public function safeties($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $safeties = (new Safety)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $safeties) {
            return $this->respondNotFound('Safeties not found.');
        }

        return $this->respond([
            'data' => $safeties->toArray(),
        ]);
    }

    public function tackles($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $tackles = (new Tackle)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $tackles) {
            return $this->respondNotFound('Tackles not found.');
        }

        return $this->respond([
            'data' => $tackles->toArray(),
        ]);
    }

    public function touchdowns($id)
    {
        $pidFirst = (new Play)->where('gid', $id)->value('pid');

        if (! $pidFirst) {
            return $this->respondNotFound('Game not found.');
        }

        $pidLast = (new Play)->orderBy('pid', 'DESC')->where('gid', $id)->value('pid');
        $touchdown = (new Touchdown)->where('pid', '>=', $pidFirst)->where('pid', '<=', $pidLast)->get();

        if (! $touchdown) {
            return $this->respondNotFound('Touchdowns not found.');
        }

        return $this->respond([
            'data' => $this->touchdownTransformer->transformCollection($touchdown->toArray()),
        ]);
    }
}
