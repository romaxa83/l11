<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Database\Factories\PostFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }
}
