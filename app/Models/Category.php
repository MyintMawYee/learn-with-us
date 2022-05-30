<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Join purchase, course and category tables 
     */
    public function purchaseVideos()
    {
        return $this->hasManyThrough('App\Models\Purchase', 'App\Models\Course', 'category_id', 'course_id');
    }

    /**
     * Join course and category tables 
     */
    public function course()
    {
        return $this->hasMany(Course::class, "category_id", "id");
    }
}
