<?php

namespace App\Http\Controllers;

use App\Models\Kicker;
use App\Transformers\KickerTransformer;
use Illuminate\Http\JsonResponse;

class KickersController extends ApiController
{
    protected $kickerTransformer;

    public function __construct(KickerTransformer $kickerTransformer)
    {
        $this->kickerTransformer = $kickerTransformer;
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
        $kickers = (new Kicker)->where('gid', $id)->get();

        if (! $kickers->count()) {
            return $this->respondNotFound('Game not found.');
        }

        return $this->respond([
            'data' => $this->kickerTransformer->transformCollection($kickers->toArray()),
        ]);
    }
}
