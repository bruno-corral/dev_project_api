<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    /**
     * @return JsonResponse  
     */
    public function index(): JsonResponse
    {
        try {
            $categories = Category::all();

            return response()->json([
                'error' => false,
                'message' => 'Categorias recuperadas com sucesso.',
                'data' => $categories
            ]);
        } catch (Exception $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * @param String $id
     * @return JsonResponse  
     */
    public function show($id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);

            return response()->json([
                'error' => false,
                'message' => 'Categoria recuperada com sucesso.',
                'data' => $category
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function create(CategoryRequest $request)
    {
        try {
            $data = $request->only(['title']);

            $category = Category::create($data);

            return response()->json([
                'error' => false,
                'message' => 'Categoria criada com sucesso.',
                'data' => $category
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function update(CategoryRequest $request)
    {
        try {
            $data = $request->only(['title']);

            $category = Category::findOrFail($request->id);

            $category->update($data);
            $category->save();

            return response()->json([
                'error' => false,
                'message' => 'Categoria atualizada com sucesso.',
                'data' => $category
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param String $id
     * @return JsonResponse  
     */
    public function remove($id): JsonResponse
    {
        try {
            $category = Category::where(["id" => $id])->delete();

            return response()->json([
                'error' => false,
                'message' => 'Categoria deletada com sucesso.',
                'data' => $category
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }
}
