<?php

namespace App\Services\Category;

use App\Contracts\Dao\Category\CategoryDaoInterface;
use App\Contracts\Services\Category\CategoryServiceInterface;
use Illuminate\Support\Facades\Lang;

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
	 * @param  $request
	 * @return \Illuminate\Http\Response
	 */
	public function saveCategory($request)
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
	 * @param  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function updateCategory($request, $id)
	{
		return $this->categoryDao->updateCategory($request, $id);
	}

	/** 
	 * Display the specified resource from storage.
	 * @param  $param
	 * @return array
	 */
	public function showCategory($id)
	{
		$imgPath = "http://127.0.0.1:8000/storage/courseimg/";
		$fcourse =  $this->categoryDao->showCategory($id);
		if ($fcourse->course->count() > 0) {
			foreach ($fcourse->course as $course) {
				$filter['id'] = $course->id;
				$filter['name'] = $course->name;
				$filter['course_cover_path'] = $course->course_cover_path;
				$filter['course_cover_link'] = $imgPath . $course->course_cover_path;
				$filter['category_id'] = $course->category_id;
				$filter["short_descrip"] = $course->short_descrip;
				$filter["description"] = $course->description;
				$filter["instructor"] = $course->instructor;
				$filter["price"] = $course->price;
				$finalData[] = $filter;
			}
			return [
				"result" => intval(Lang::get("messages.result.success")),
				"message" => Lang::get("messages.categorydata.found"),
				"data" => $finalData,
			];
		}
		return [
			"result" => intval(Lang::get("messages.result.fail")),
			"message" => Lang::get("messages.categorydata.notfound")
		];
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

	/**
	 * Count all Category
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function countCategory()
	{
		return $this->categoryDao->countCategory();
	}

	/**
	 * Count category which buy users
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function countPurchaseCategory()
	{
		return $this->categoryDao->countPurchaseCategory();
	}
}
