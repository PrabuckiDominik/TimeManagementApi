<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Actions\DeleteTagAction;
use TimeManagement\Actions\GetUserTagsAction;
use TimeManagement\Actions\ShowTagAction;
use TimeManagement\Actions\StoreTagAction;
use TimeManagement\Actions\UpdateTagAction;
use TimeManagement\Http\Requests\StoreTagRequest;
use TimeManagement\Http\Requests\UpdateTagRequest;
use TimeManagement\Http\Resources\TagResource;
use TimeManagement\Models\Tag;

class TagController extends Controller
{
    public function index(Request $request, GetUserTagsAction $action): JsonResponse
    {
        $this->authorize("viewAny", Tag::class);

        $tags = $action->execute($request->user());

        return response()->json([
            "data" => TagResource::collection($tags),
        ]);
    }

    public function show(Tag $tag, ShowTagAction $action): JsonResponse
    {
        $this->authorize("view", $tag);

        $tag = $action->execute($tag);

        return response()->json([
            "data" => new TagResource($tag),
        ]);
    }

    public function store(StoreTagRequest $request, StoreTagAction $action): JsonResponse
    {
        $this->authorize("create", Tag::class);

        $tag = $action->execute($request->user(), $request->toDto());

        return response()->json([
            "message" => __("tags.created"),
            "data" => new TagResource($tag),
        ], Status::HTTP_CREATED);
    }

    public function update(UpdateTagRequest $request, Tag $tag, UpdateTagAction $action): JsonResponse
    {
        $this->authorize("update", $tag);

        $tag = $action->execute($tag, $request->toDto());

        return response()->json([
            "message" => __("tags.updated"),
            "data" => new TagResource($tag),
        ]);
    }

    public function destroy(Tag $tag, DeleteTagAction $action): JsonResponse
    {
        $this->authorize("delete", $tag);

        $action->execute($tag);

        return response()->json([
            "message" => __("tags.deleted"),
        ]);
    }
}
