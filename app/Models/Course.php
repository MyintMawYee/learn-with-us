<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'course_cover_path', 'video_path', 'category_id', 
        'short_descrip', 'description', 'instructor', 'price'
    ];
}
