<?php

namespace App\Services\Category;

use App\Contracts\Dao\Category\CategoryDaoInterface;
use App\Contracts\Services\Category\CategoryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Service class for category.
 */
class CategoryService implements CategoryServiceInterface
{
	/**
	 * category dao
	 */
	private $categoryDao;
	
	/**
	 * Class Constructor
	 * @param CategoryDaoInterface
	 * @return
	 */
	public function __construct(CategoryDaoInterface $categoryDao)
	{
		$this->categoryDao = $categoryDao;
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function saveCategory(Request $request)
	{
		return $this->categoryDao->saveCategory($request);
	}

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function delete($id)
	{
		return $this->categoryDao->delete($id);
	}

	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function updateCategory(Request $request, $id)
	{
		return $this->categoryDao->updateCategory($request, $id);
	}

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function showCategory($id)
	{
		return $this->categoryDao->showCategory($id);
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function allCategory()
	{
		return $this->categoryDao->allCategory();
	}
}
