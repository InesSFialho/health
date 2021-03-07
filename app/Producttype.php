<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producttype extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category_id'
    ];
    

    public function category(){
        return $this->belongsTo(Category::class ,'category_id')->first();
    }
}
