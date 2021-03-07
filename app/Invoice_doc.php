<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    

class Invoice_doc extends Model
{
    use SoftDeletes;


    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
