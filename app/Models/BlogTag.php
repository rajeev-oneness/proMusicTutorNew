<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogTag extends Model
{
    use HasFactory, SoftDeletes;

    function blogs_data($blogTagId)
    {
        $data = Blog::whereRaw('FIND_IN_SET("'.$blogTagId.'",tags)')->get();
        return $data;
        return $this->hasMany('App\Models\Blog','tags','id');
    }
}
