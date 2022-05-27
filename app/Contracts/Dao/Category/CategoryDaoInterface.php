<?php

namespace App\Contracts\Dao\Category;

use Illuminate\Http\Request;

/**
 * Interface for Data Accessing Object of Category
 */
interface CategoryDaoInterface
{
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function saveCategory(Request $request);

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function allCategory();

	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function delete($id);

	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function updateCategory(Request $request, $id);

	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function showCategory($id);

     /**
     * Count all Category
     *
     * @return \Illuminate\Http\Response
     */
	public function countCategory();

     /**
     * Count category which buy users
     *
     * @return \Illuminate\Http\Response
     */
    public function countPurchaseCategory();
}
