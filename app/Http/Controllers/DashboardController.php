<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TimeManagement\Actions\GetDashboardStatsAction;
use TimeManagement\Http\Resources\DashboardStatsResource;
use TimeManagement\Models\Task;

class DashboardController extends Controller
{
    public function show(Request $request, GetDashboardStatsAction $action): JsonResponse
    {
        $this->authorize("viewAny", Task::class);

        $stats = $action->execute($request->user());

        return response()->json([
            "data" => new DashboardStatsResource($stats),
        ]);
    }
}
