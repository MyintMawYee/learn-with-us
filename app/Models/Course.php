<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'course_cover_path', 'video_path', 'category_id',
        'short_descrip', 'description', 'instructor', 'price'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Join course and course_videos tables 
     */
    public function video()
    {
        return $this->hasMany(CourseVideo::class, "course_id", "id");
    }

    /**
     * Join course and category tables 
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}
