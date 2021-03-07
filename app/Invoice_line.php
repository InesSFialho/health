<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Invoice;
use App\Budget_line;
use App\Work;
use App\Producttype;
use DB;

class Invoice_line extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function budget_line()
    {
        return $this->belongsTo(Budget_line::class, 'budget_line_id');
    }

    public function work()
    {
        return $this->belongsTo(Work::class, 'work_id');
    }
    
    public function producttype()
    {
        return $this->belongsTo(Producttype::class, 'producttype_id');
    }

    public function total($invoice_id)
    {
        $invoice_total=Invoice_line::where('invoice_id', '=', $invoice_id)
        ->sum('applied_price');

        return $invoice_total;
    }

    public function payed()
    {
        $invoice_payments=Invoice_payment::where('invoice_line_id', $this->id)
        ->sum('value');
        
        return $invoice_payments;
    }

    public function line_debt()
    {
        return $this->applied_price_with_iva() - $this->payed();
    }

    public function iva(){
        return $this->belongsTo(Iva::class ,'iva_id');
    }
    
    public function budget(){
        return Budget::select('name')
        ->where('id', $this->budget_line->budget_id)
        ->first()['name'];
    }
    
    public function total_payments()
    {
        $total = Invoice_payment::select('value')
        ->where('invoice_line_id', $this->id)
        ->whereNull('deleted_at')
        ->get()
        ->sum(function($total){ 
            return $total->value; 
        });

        return $total;
    }
    
    public function applied_price_with_iva()
    {
        $value = Invoice_line::where('invoice_lines.id', $this->id)
        ->whereNull('invoice_lines.deleted_at')
        ->join('ivas', function($join)
        {
            $join->on('invoice_lines.iva_id', '=', 'ivas.id')
                ->whereNULL('ivas.deleted_at');
        })
        ->selectRaw(DB::raw('SUM(applied_price*(1+ivas.value/100)) AS p'))
        ->pluck('p')
        ->first();

        return round($value, 2);
    }

    public function applied_price_according_ivadevido()
    {
        $value = Invoice_line::
        join('ivas', function($join)
        {
            $join->on('invoice_lines.iva_id', '=', 'ivas.id')
            ->whereNULL('ivas.deleted_at');
        })
        ->selectRaw(DB::raw('CASE WHEN ivadevido = 1 THEN applied_price ELSE (applied_price*(1+ivas.value/100)) END AS p'))
        ->where('invoice_lines.id', $this->id)
        ->whereNull('invoice_lines.deleted_at')
        ->pluck('p')
        ->first();

        return round($value, 2);
    }

    public function debt()
    {
        return $this->applied_price_with_iva() - $this->total_payments();
    }
}
