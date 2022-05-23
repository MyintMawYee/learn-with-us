<?php

namespace App\Contracts\Dao\Course;

interface CourseDaoInterface
{
    
    /**
     * Summary of create
     * @param mixed $validated
     * @return Object
     */
    public function create($validated);

    /**
     * Summary of edit
     * @return Object
     */
    public function edit($id);

    /**
     * Summary of update
     * @param mixed $validated
     * @param mixed $id
     * @return void
     */
    public function update($object, $validated);

}
