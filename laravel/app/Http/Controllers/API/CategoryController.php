<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = DB::table('categories')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success',
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validate($request ,[
            'name' => 'required|max:100',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'Success',
            'data' => $category,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'Mise à jour avec success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json([
            'status' => 'Supprimer avec success'
        ]);
    }
}
