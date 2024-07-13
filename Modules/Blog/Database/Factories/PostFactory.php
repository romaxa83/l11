<?php

namespace Modules\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = \Modules\Blog\Models\Post::class;

    public function definition(): array
    {
        return [];
    }
}

