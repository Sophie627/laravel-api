<?php

namespace App\Http\Controllers;

use App\Models\Drive;
use App\Transformers\DriveTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DrivesController extends ApiController
{
    protected $driveTransformer;

    public function __construct(DriveTransformer $driveTransformer)
    {
        $this->driveTransformer = $driveTransformer;
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
        if (is_numeric($id)) {
            $drives = (new Drive)->where('gid', $id)->get();

            if (! $drives->count()) {
                return $this->respondNotFound('Game not found.');
            }
        } else {
            $count = $request->input('count') ?: 1000;
            if ($count > 1000) {
                $count = 1000;
            }
            $start = $request->input('start') - 1;

            $drives = (new Drive)->where('tname', $id)->take($count)->skip($start)->get();

            if (! $drives->count()) {
                return $this->respondNotFound('Team not found.');
            }
        }

        return $this->respond([
            'data' => $this->driveTransformer->transformCollection($drives->toArray()),
        ]);
    }
}
