<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
Use DB;

use App\Invoice;
use App\Budget;
use App\Supplier;

class Supplier extends Model
{
    use SoftDeletes;

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function current_account_lines_total()
    {
        $total = Invoice_line::select('invoice_lines.applied_price', 'ivas.value as iva')
        ->join('invoices', function($join)
        {
            $join->on('invoice_lines.invoice_id', '=', 'invoices.id')
                ->whereNULL('invoices.deleted_at');
        })
        ->join('suppliers', function($join)
        {
            $join->on('invoices.supplier_id', '=', 'suppliers.id')
                ->whereNULL('invoices.deleted_at');
        })
        ->join('ivas', function($join)
        {
            $join->on('invoice_lines.iva_id', '=', 'ivas.id')
                ->whereNULL('invoices.deleted_at');
        })
        ->where('suppliers.id', $this->id)
        ->whereNull('invoice_lines.deleted_at')
        ->get()
        ->sum(function($total){ 
            return $total->applied_price * (1 + ($total->iva / 100)); 
        });

        return $total;
    }

    public function already_payed()
    {
        $total =  Supplier::select('invoice_payments.value')
        ->join('invoices', function($join)
        {
            $join->on('invoices.supplier_id', '=', 'suppliers.id')
                ->whereNULL('invoices.deleted_at');
        })
        ->join('invoice_payments', function($join)
        {
            $join->on('invoices.id', '=', 'invoice_payments.invoice_line_id')
                ->whereNULL('invoice_payments.deleted_at');
        })
        ->where('suppliers.id', $this->id)
        ->whereNull('suppliers.deleted_at')
        ->get()
        ->sum(function($total){ 
            return $total->value;
        });

        return $total;
    }

    public function bill()
    {
        $total = Supplier::select('invoice_lines.applied_price', 'ivas.value as iva')
        ->join('invoices', function($join)
        {
            $join->on('invoices.supplier_id', '=', 'suppliers.id')
                ->whereNULL('invoices.deleted_at');
        })
        ->join('invoice_lines', function($join)
        {
            $join->on('invoice_lines.invoice_id', '=', 'invoices.id')
                ->whereNULL('invoice_lines.deleted_at');
        })
        ->join('ivas', function($join)
        {
            $join->on('invoice_lines.iva_id', '=', 'ivas.id')
                ->whereNULL('ivas.deleted_at');
        })
        ->where('suppliers.id', $this->id)
        ->whereNull('suppliers.deleted_at')
        ->get()
        ->sum(function($total){ 
            return $total->applied_price * (1 + ($total->iva / 100)); 
        });

        return $total;
            
    }

    public function payments()
    {
        return Invoice_payment::select('value', 'invoice_payments.created_at', 'invoice_id')
        ->join('invoice_lines', function($join)
            {
                $join->on('invoice_lines.id', '=', 'invoice_payments.invoice_line_id')
                    ->where('supplier_id', $this->id)
                    ->whereNULL('invoice_lines.deleted_at');
            })
        ->whereNull('invoice_payments.deleted_at')
        ->get();
    }

    public function deft()
    {
        $total = $this->bill() - $this->already_payed();
        
        return $total;
    }

    public function budget_lines()
    {
        return Budget_line::select('name', 'applied_price', 'ivas.value')
        ->join('ivas', function($join)
        {
            $join->on('ivas.id', '=', 'invoice_lines.iva_id')
                 ->whereNULL('ivas.deleted_at');
        })
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('budget_lines.work_id', $this->id)
        ->whereNull('budget_lines.deleted_at')
        ->get();
    }

    public function supplier_invoices()
    {
        $invoices = Invoice::where('supplier_id', $this->id)
        ->whereNull('invoices.deleted_at')
        ->get();

        return $invoices;
    }

    public function paymentsByDate($date)
    {
        $payments = Invoice_payment::
        select( 'invoices.name as invoice',
                'invoice_payments.value as value',
                'invoice_payments.*',
                'producttypes.name as product')
        ->join('invoice_lines', function($join)
        {
            $join->on('invoice_lines.id', '=', 'invoice_payments.invoice_line_id')
                 ->whereNULL('invoice_lines.deleted_at');
        })
        ->join('invoices', function($join)
        {
            $join->on('invoices.id', '=', 'invoice_lines.invoice_id')
                 ->whereNULL('invoices.deleted_at');
        })
        ->join('producttypes', function($join)
        {
            $join->on('producttypes.id', '=', 'invoice_lines.producttype_id')
                 ->whereNULL('producttypes.deleted_at');
        })
        ->where('invoice_payments.date', $date)
        ->where('invoices.supplier_id', $this->id)
        ->orderBy('invoice_payments.created_at', 'desc')
        ->get();

        return $payments;
    }
}
