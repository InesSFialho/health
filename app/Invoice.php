<?php

namespace App;
use Response;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use App\Invoice_line;
use App\Invoice_doc;
use DB;

class Invoice extends Model
{
    use SoftDeletes;
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function lines()
    {
        return $this->hasMany(Invoice_line::class);
    }

    public function docs()
    {
        return $this->hasMany(Invoice_doc::class);
    }

    public function years()
    {
        $years=Invoice::selectRaw('YEAR(date) as year')
        ->whereNull('deleted_at')
        ->groupby('year')     
        ->orderby('year', 'desc')
        ->get();        
        
        return $years;
    }

    public function details($outros, $ivadevido)
    {
        $array=Invoice_line::
        select(
            'invoice_lines.applied_price',
            'ivas.value',
            'invoices.id',
            'invoice_lines.outros',
            'invoice_lines.ivadevido',
            'suppliers.name as supplier',
            'invoices.name as invoice',
            'invoices.date',)
        ->selectRaw('YEAR(date) as invoice_year')
        ->selectRaw('MONTH(date) as invoice_month')
        ->join('ivas', 'invoice_lines.iva_id', '=', 'ivas.id')
        ->join('invoices', 'invoice_lines.invoice_id', '=', 'invoices.id')
        ->join('suppliers', 'invoices.supplier_id', '=', 'suppliers.id')
        ->where('invoice_lines.outros', '=', $outros) 
        ->where('invoice_lines.ivadevido', '=', $ivadevido)
        ->whereNull('invoice_lines.deleted_at')
        ->whereNull('ivas.deleted_at')
        ->whereNull('invoices.deleted_at')
        ->whereNull('suppliers.deleted_at')
        ->get();

        foreach ($array as &$value) {
            $iva = (int)($value['value']) * (int)$value['applied_price'] / 100;
            $value['iva'] = $iva;
            switch ($value['invoice_month']) {
                case 1:
                case 2:
                case 3:
                    $value['trimester'] = 1;                    
                    break;
                case 4:
                case 5:
                case 6:
                    $value['trimester'] = 2;                    
                    break;
                case 7:
                case 8:
                case 9:
                    $value['trimester'] = 3;                    
                    break;
                default:
                    $value['trimester'] = 4;                    
                    break;
                
            }
        }

        return $array;
    }

    public function details_by_trimester($year, $trimester, $ivadevido)
    {

        switch ($trimester) {
            case 1:
                $month_1 = 1;                  
                $month_2 = 2;                  
                $month_3 = 3;                  
                break;
            case 2:
                $month_1 = 4;                  
                $month_2 = 5;                  
                $month_3 = 6;                      
                break;
            case 3:
                $month_1 = 7;                  
                $month_2 = 8;                  
                $month_3 = 9;  
                break;
            default:
                $month_1 = 10;                  
                $month_2 = 11;                  
                $month_3 = 12;                     
                break;
        }

        $array=Invoice_line::
        select(
            'invoice_lines.applied_price',
            'ivas.value',
            'invoices.id',
            'invoice_lines.ivadevido',
            'suppliers.name as supplier',
            'invoices.name as invoice',
            'invoices.date',)
        ->selectRaw('YEAR(date) as invoice_year')
        ->selectRaw('MONTH(date) as invoice_month')
        ->join('ivas', 'invoice_lines.iva_id', '=', 'ivas.id')
        ->join('invoices', 'invoice_lines.invoice_id', '=', 'invoices.id')
        ->join('suppliers', 'invoices.supplier_id', '=', 'suppliers.id')
        ->whereYear('invoices.date', $year)
        ->whereMonth('invoices.date', '>=', $month_1)
        ->whereMonth('invoices.date', '<=', $month_3)
        ->where('invoice_lines.ivadevido', '=', $ivadevido)
        ->whereNull('invoice_lines.deleted_at')
        ->whereNull('ivas.deleted_at')
        ->whereNull('invoices.deleted_at')
        ->whereNull('suppliers.deleted_at')
        ->orderBy('invoices.date')
        ->get()
        ->groupby('invoice_month');        

        return $array;
    }

    public function totals($year, $trimester, $ivadevido)
    {
        $array = $this->details_by_trimester($year, $trimester, $ivadevido);

        $total_applied_price = 0;
        $total_iva_value = 0;
        $total_price_with_iva = 0;

        foreach ($array as $key => $value) {
            foreach ($value as $k => $v) {
                $total_applied_price += $v->applied_price;
                $total_iva_value += $v->value * $v->applied_price / 100;
                $total_price_with_iva += ($v->value * $v->applied_price / 100) + $v->applied_price;
            }
        }
        return [
            'total_applied_price' => $total_applied_price,
            'total_iva_value' => $total_iva_value,
            'total_price_with_iva'=>$total_price_with_iva
        ];
    }

    public function total_applied_price_with_iva($invoice_id)
    {
        $total = Invoice_line::select('applied_price', 'ivas.value as iva')
        ->join('ivas', 'invoice_lines.iva_id', '=', 'ivas.id')
        ->where('invoice_id', $invoice_id)
        ->whereNULL('invoice_lines.deleted_at')
        ->get()
        ->sum(function($total){ 
            return $total->applied_price * (1 + ($total->iva / 100)); 
        });

        return number_format($total,2);
    }

    public function invoice_lines()
    {
        $lines = Invoice_line::select('invoice_lines.*')
        ->join('works', 'works.id', '=', 'invoice_lines.work_id')
        ->whereNull('invoice_lines.deleted_at')
        ->where('invoice_lines.invoice_id', $this->id)
        ->whereNULL('works.deleted_at')
        ->get();

        return $lines;
    }

    public function payments()
    {
        $lines = Invoice_payment::select(
            'invoice_payments.value',
            'invoice_payments.date',
            'producttypes.name as product')
        ->join('invoice_lines', 'invoice_lines.id', '=', 'invoice_payments.invoice_line_id')
        ->join('invoices', 'invoices.id', '=', 'invoice_lines.invoice_id')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->selectRaw(DB::raw('invoice_lines.applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->whereNULL('invoice_payments.deleted_at')
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('invoices.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->where('invoices.id', $this->id)
        ->orderBy('invoice_payments.date', 'desc')
        ->orderBy('invoice_payments.created_at', 'desc')
        ->get();

        return $lines;
    }
}
