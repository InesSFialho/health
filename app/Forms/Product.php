<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Traits\LaratrustUserTrait;

class Product extends Model
{
    use SoftDeletes;
    use LaratrustUserTrait;

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

}
