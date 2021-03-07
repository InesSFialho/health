<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    

class Budget_doc extends Model
{
    use SoftDeletes;


    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

}
