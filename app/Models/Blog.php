<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    public function blog_category()
    {
        return $this->belongsTo('App\Models\BlogCategory','blogCategoryId','id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User','createdBy','id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\BlogComment','blogId','id')->latest();
    }
}
