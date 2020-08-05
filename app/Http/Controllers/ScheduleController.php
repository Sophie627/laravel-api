<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\JsonResponse;

class ScheduleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $schedule = Schedule::all();

        return $this->respond([
            'data' => $schedule->toArray(),
        ]);
    }
}
