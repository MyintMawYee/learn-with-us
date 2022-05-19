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
	 * To save Category
	 * @param Request $request request with inputs
	 * @return Object $post saved category
	 */
	public function saveCategory(Request $request)
	{
		return $this->categoryDao->saveCategory($request);
	}

	//To delete Category
	public function delete($id)
	{
		return $this->categoryDao->delete($id);
	}

	//To update Category
	public function updateCategory(Request $request, $id)
	{
		return $this->categoryDao->updateCategory($request, $id);
	}

	//To show Category related id
	public function showCategory($id)
	{
		return $this->categoryDao->showCategory($id);
	}

	//To show all category
	public function allCategory()
	{
		return $this->categoryDao->allCategory();
	}
}
