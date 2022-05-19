<?php

namespace App\Dao\Category;


use App\Contracts\Dao\Category\CategoryDaoInterface;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Data accessing object for post
 */
class CategoryDao implements CategoryDaoInterface
{
    /**
     * To save Category
     * @param Request $request request with inputs
     * @return Object $post saved post
     */
    public function saveCategory(Request $request)
    {
        $category = Category::create([
            'name' => $request->name,
        ]);
        return response()->json([$category, 'msg' => 'Category has been created successfully'], 200);
    }

    //To show all category
    public function allCategory()
    {
        $categories = Category::all();

        return response()->json($categories, 200);
    }

    //To show data related id
    public function showCategory($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category, 200);
    }

    //To delete Category
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['msg' => 'Category has been deleted successfully'],200);
    }

    //To update Category
    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);
        return response()->json(['msg' => 'Category has been updated Successfully'], 200);
    }
}
