<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PersonalAccessToken extends \Laravel\Sanctum\PersonalAccessToken
{
    use SoftDeletes;

    protected $guarded = ['id'];
}
