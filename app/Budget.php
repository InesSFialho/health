<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Budget_line;

class Budget extends Model
{
    use SoftDeletes;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function budget_lines()
    {
        return $this->hasMany(Budget_line::class);
    }

}
