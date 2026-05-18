<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Http\Resources\ActivityLogResource;

class ActivityLogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $logs = Activity::query()
            ->with(["causer", "subject"])
            ->when(
                $request->query("event"),
                fn($query, $event) => $query->where("event", $event),
            )
            ->when(
                $request->query("log_name"),
                fn($query, $logName) => $query->where("log_name", $logName),
            )
            ->when(
                $request->query("causer_id"),
                fn($query, $causerId) => $query->where("causer_id", $causerId),
            )
            ->latest()
            ->paginate(
                perPage: min((int)$request->query("per_page", 20), 100),
            );

        return response()->json([
            "data" => ActivityLogResource::collection($logs),
            "meta" => [
                "current_page" => $logs->currentPage(),
                "last_page" => $logs->lastPage(),
                "per_page" => $logs->perPage(),
                "total" => $logs->total(),
            ],
        ], Status::HTTP_OK);
    }
}
