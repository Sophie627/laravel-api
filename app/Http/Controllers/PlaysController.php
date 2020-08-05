<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Conv;
use App\Models\Fgxp;
use App\Models\Fumble;
use App\Models\Game;
use App\Models\Intercpt;
use App\Models\Koff;
use App\Models\Pass;
use App\Models\PBP;
use App\Models\Penalty;
use App\Models\Play;
use App\Models\Punt;
use App\Models\Rush;
use App\Models\Sack;
use App\Models\Safety;
use App\Models\Tackle;
use App\Transformers\Pass2Transformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaysController extends ApiController
{
    protected $passTransformer;

    public function __construct(
        Pass2Transformer $passTransformer
    ) {
        $this->passTransformer = $passTransformer;
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

    public function show(Request $request, $id)
    {
        $mode = $request->input('mode');

        if ($mode && $mode !== 'flat' && $mode !== 'expanded') {
            return $this->respondNotFound('Valid modes are: flat, expanded.');
        }

        if (! $mode) {
            $plays = (new Play)->where('gid', $id)->get();

            if (! $plays->count()) {
                return $this->respondNotFound('Game not found.');
            }

            return $this->respond([
                'data' => $plays->toArray(),
            ]);
        }

        if ($mode === 'flat') {
            $plays = (new PBP)->where('gid', $id)->get();

            if (! $plays->count()) {
                return $this->respondNotFound('Game not found.');
            }

            return $this->respond([
                'data' => $plays->toArray(),
            ]);
        }

        if ($mode === 'expanded') {
            global $detail;

            $plays = (new Play)->where('gid', $id)->get();

            if (! $plays->count()) {
                return $this->respondNotFound('Game not found.');
            }

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
                            $play->pass = $this->passTransformer->transform($detail);
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
}
