<?php

namespace App\Contracts\Services\Category;

use Illuminate\Http\Request;

/**
* Interface for post service
*/
interface CategoryServiceInterface
{
	/**
	* To save Category
	* @param Request $request request with inputs
	* @return Object $post saved post
	*/
	public function saveCategory(Request $request);

	//To show all category
	public function allCategory();

	//To delete Category
	public function delete($id);

	//To update Category
	public function updateCategory(Request $request, $id);

	//To show Category related id
	public function showCategory($id);
}
