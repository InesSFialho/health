<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

use App\Budget;
use App\Producttype;
use App\Iva;
use App\Invoice_line;

class Budget_line extends Model
{
    use SoftDeletes;

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function producttype(){
        
        return $this->belongsTo(Producttype::class, 'producttype_id');
    }

    public function invoice_line(){
        
        return $this->hasOne(Invoice_line::class ,'budget_line_id');
    }

    public function iva(){
        return $this->belongsTo(Iva::class ,'iva_id')->first();
    }

    public function budget_with_iva()
    {
        $value=Budget_line::join('ivas', 'budget_lines.iva_id', '=', 'ivas.id')
        ->where('budget_lines.id', $this->id)
        ->whereNULL('budget_lines.deleted_at')
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS value'))
        ->first()['value'];

        return $value;
    }

    public function applied_price_according_ivadevido()
    {
        $value = Budget_line::
        join('ivas', 'budget_lines.iva_id', '=', 'ivas.id')
        ->selectRaw(DB::raw('CASE WHEN ivadevido = 1 THEN applied_price ELSE (applied_price*(1+ivas.value/100)) END AS p'))
        ->where('budget_lines.id', $this->id)
        ->whereNull('budget_lines.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->pluck('p')
        ->first();

        return $value;
    }
}
