<?php

namespace App\Contracts\Dao\Category;

/**
 * Interface for Data Accessing Object of Category
 */
interface CategoryDaoInterface
{
     /**
      * Store a newly created resource in storage.
      *
      * @param  $request
      * @return \Illuminate\Http\Response
      */
     public function saveCategory($request);

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
      * @param  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function updateCategory($request, $id);

     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function showCategoryName($id);

     /**
      * Display the specified resource related to courses.
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
