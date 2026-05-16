<?php

declare(strict_types=1);

namespace TimeManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as Status;
use TimeManagement\Actions\DeleteCategoryAction;
use TimeManagement\Actions\GetUserCategoriesAction;
use TimeManagement\Actions\ShowCategoryAction;
use TimeManagement\Actions\StoreCategoryAction;
use TimeManagement\Actions\UpdateCategoryAction;
use TimeManagement\Http\Requests\StoreCategoryRequest;
use TimeManagement\Http\Requests\UpdateCategoryRequest;
use TimeManagement\Http\Resources\CategoryResource;
use TimeManagement\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request, GetUserCategoriesAction $action): JsonResponse
    {
        $this->authorize("viewAny", Category::class);

        $categories = $action->execute($request->user());

        return response()->json([
            "data" => CategoryResource::collection($categories),
        ]);
    }

    public function show(Category $category, ShowCategoryAction $action): JsonResponse
    {
        $this->authorize("view", $category);

        $category = $action->execute($category);

        return response()->json([
            "data" => new CategoryResource($category),
        ]);
    }

    public function store(StoreCategoryRequest $request, StoreCategoryAction $action): JsonResponse
    {
        $this->authorize("create", Category::class);

        $category = $action->execute($request->user(), $request->toDto());

        return response()->json([
            "message" => __("categories.created"),
            "data" => new CategoryResource($category),
        ], Status::HTTP_CREATED);
    }

    public function update(UpdateCategoryRequest $request, Category $category, UpdateCategoryAction $action): JsonResponse
    {
        $this->authorize("update", $category);

        $category = $action->execute($category, $request->toDto());

        return response()->json([
            "message" => __("categories.updated"),
            "data" => new CategoryResource($category),
        ]);
    }

    public function destroy(Category $category, DeleteCategoryAction $action): JsonResponse
    {
        $this->authorize("delete", $category);

        $action->execute($category);

        return response()->json([
            "message" => __("categories.deleted"),
        ]);
    }
}
