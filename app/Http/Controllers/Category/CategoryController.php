<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Contracts\Services\Category\CategoryServiceInterface;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Category interface
     */
    private $categoryInterface;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoryServiceInterface $categoryServiceInterface)
    {
        $this->categoryInterface = $categoryServiceInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryInterface->allCategory();
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|max:255',
        ]);
        $category = $this->categoryInterface->saveCategory($request);
        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryInterface->showCategory($id);
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = $this->categoryInterface->updateCategory($request, $id);
        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryInterface->delete($id);
        return $category;
    }
}
