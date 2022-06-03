<?php

namespace App\Dao\Category;


use App\Contracts\Dao\Category\CategoryDaoInterface;
use App\Models\Category;

/**
 * Data accessing object for category
 */
class CategoryDao implements CategoryDaoInterface
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function saveCategory($request)
    {
        $category = Category::create([
            'name' => $request->name,
        ]);
        return response()->json([$category, 'message' => 'Category has been created successfully'], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allCategory()
    {
        $categories = Category::withCount(['course'])->get();
        return response()->json($categories, 200);
    }

    /**
     * Show the specified resource from storage.
     *
     * @param  $param
     * @return Object
     */
    public function showCategoryName($id)
    {
        $category = Category::findOrFail($id);
        return $category;
    }

    /**
     * Show the specified resource from storage.
     *
     * @param  $param
     * @return Object
     */
    public function showCategory($id)
    {
        $category = Category::with('course')->findOrFail($id);
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['message' => 'Category has been deleted successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCategory($request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);
        return response()->json([$category, 'message' => 'Category has been updated Successfully'], 200);
    }

    /**
     * Count all Category
     *
     * @return \Illuminate\Http\Response
     */
    public function countCategory()
    {
        $categories = Category::all()->count();
        return response()->json([
            'result' => 1,
            'count' => $categories
        ]);
    }

    /**
     * Count category which buy users
     *
     * @return \Illuminate\Http\Response
     */
    public function countPurchaseCategory()
    {
        $categories = Category::withCount(['purchaseVideos'])->get();
        return response()->json($categories, 200);
    }
}
