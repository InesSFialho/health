<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Invoice_line;
use App\Invoice_payment;
use App\Producttype;
use App\Category;
Use DB;

class Work extends Model
{
    use SoftDeletes;

    public function invoice_lines($category_id)
    {
        $invoice_lines=Invoice_line::
        select('invoice_lines.*',
            'producttypes.name as producttype',
            'suppliers.id as supplier_id',
            'suppliers.name as supplier',
            'invoices.id as invoice_id',
            'invoices.name as invoice',
            'invoices.date as date')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->join('categories', 'categories.id', '=', 'producttypes.category_id')
        ->join('invoices', 'invoices.id', '=', 'invoice_lines.invoice_id')
        ->join('suppliers', 'suppliers.id', '=', 'invoices.supplier_id')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('categories.id', $category_id)
        ->where('invoice_lines.work_id', $this->id)
        ->where('outros', 0)
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('suppliers.deleted_at')
        ->whereNULL('invoices.deleted_at')
        ->whereNULL('categories.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->orderBy('invoices.date', 'asc')
        ->get();

        return $invoice_lines;
    }

    public function budget_lines($category_id, $work_id)
    {
        $budget_lines=Budget_line::select('budget_lines.*','producttypes.name as producttype','suppliers.id as supplier_id','suppliers.name as supplier', 'budgets.id as budget_id', 'budgets.name as budget')
        ->join('producttypes', 'budget_lines.producttype_id', '=', 'producttypes.id')
        ->join('categories', 'producttypes.category_id', '=', 'categories.id')
        ->join('budgets', 'budget_lines.budget_id', '=', 'budgets.id')
        ->join('suppliers', 'budgets.supplier_id', '=', 'suppliers.id')
        ->where('categories.id', '=', $category_id)
        ->where('budget_lines.work_id', '=', $work_id)
        ->get();

        return $budget_lines;
    }

    public function real_invoice_lines($category_id)
    {
        $invoice_lines=Invoice_line::
        select('invoice_lines.*',
            'producttypes.name as producttype',
            'suppliers.id as supplier_id',
            'suppliers.name as supplier',
            'invoices.id as invoice_id',
            'invoices.name as invoice',
            'invoices.date as date')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->join('categories', 'categories.id', '=', 'producttypes.category_id')
        ->join('invoices', 'invoices.id', '=', 'invoice_lines.invoice_id')
        ->join('suppliers', 'suppliers.id', '=', 'invoices.supplier_id')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('categories.id', $category_id)
        ->where('invoice_lines.work_id', $this->id)
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('suppliers.deleted_at')
        ->whereNULL('invoices.deleted_at')
        ->whereNULL('categories.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->orderBy('invoices.date', 'asc')
        ->get();

        return $invoice_lines;
    }

    public function invoice_lines_count($category_id, $work_id)
    {
        $invoice_lines_count=Invoice_line::
        join('producttypes', 'invoice_lines.producttype_id', '=', 'producttypes.id')
        ->join('categories', 'producttypes.category_id', '=', 'categories.id')
        ->where('categories.id', '=', $category_id)
        ->where('invoice_lines.work_id', '=', $work_id)
        ->where('outros', '=', 0)
        ->count();

        return $invoice_lines_count;
    }

    public function budget_lines_count($category_id, $work_id)
    {
        $budget_lines_count=Budget_line::
        join('producttypes', 'budget_lines.producttype_id', '=', 'producttypes.id')
        ->join('categories', 'producttypes.category_id', '=', 'categories.id')
        ->where('categories.id', '=', $category_id)
        ->where('budget_lines.work_id', '=', $work_id)
        ->count();

        return $budget_lines_count;
    }

    public function real_invoice_lines_count($category_id, $work_id)
    {
        $invoice_lines_count=Invoice_line::
        join('producttypes', 'invoice_lines.producttype_id', '=', 'producttypes.id')
        ->join('categories', 'producttypes.category_id', '=', 'categories.id')
        ->where('categories.id', '=', $category_id)
        ->where('invoice_lines.work_id', '=', $work_id)
        ->count();

        return $invoice_lines_count;
    }

    public function total_by_category($category_id)
    {
        return Invoice_line::select('applied_price', 'ivas.value as iva')
        ->join('ivas', 'invoice_lines.iva_id', '=', 'ivas.id')
        ->join('producttypes', 'invoice_lines.producttype_id', '=', 'producttypes.id')
        ->where('work_id', $this->id)
        ->where('outros', 0)
        ->where('category_id', $category_id)
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->get()
        ->sum(function($total){
            return $total->applied_price * (1 + ($total->iva / 100));
        });
    }

    public function real_total_by_category($category_id, $work_id)
    {
        $total=Invoice_line::
        select('invoice_lines.*',
            'producttypes.name as producttype',
            'suppliers.id as supplier_id',
            'suppliers.name as supplier',
            'invoices.id as invoice_id',
            'invoices.name as invoice',
            'invoices.date as date')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->join('categories', 'categories.id', '=', 'producttypes.category_id')
        ->join('invoices', 'invoices.id', '=', 'invoice_lines.invoice_id')
        ->join('suppliers', 'suppliers.id', '=', 'invoices.supplier_id')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('invoice_lines.work_id', $this->id)
        ->where('outros', 0)
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('suppliers.deleted_at')
        ->whereNULL('invoices.deleted_at')
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('categories.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->sum(function($total){
            return $applied_price_with_iva;
        });

        return $total;
    }

    public function total_budget_by_category($category_id)
    {
        $total = Budget_line::select('budget_lines.applied_price', 'ivas.value as iva')
        ->join('ivas', 'budget_lines.iva_id', '=', 'ivas.id')
        ->join('producttypes', 'budget_lines.producttype_id', '=', 'producttypes.id')
        ->where('work_id', $this->id)
        ->where('category_id', '=', $category_id)
        ->get()
        ->sum(function($total){
            return $total->applied_price * (1 + ($total->iva / 100));
        });

        return $total;
    }

    public function total()
    {
        $total=Invoice_line::select('applied_price', 'ivas.value as iva')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->join('categories', 'categories.id', '=', 'producttypes.category_id')
        ->join('invoices', 'invoices.id', '=', 'invoice_lines.invoice_id')
        ->join('suppliers', 'suppliers.id', '=', 'invoices.supplier_id')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->where('invoice_lines.work_id', $this->id)
        ->where('outros', 0)
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('suppliers.deleted_at')
        ->whereNULL('invoices.deleted_at')
        ->whereNULL('categories.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->get()
        ->sum(function($total){
            return $total->applied_price * (1 + ($total->iva / 100));
        });

        return $total;
    }

    public function real_total()
    {
        $total=Invoice_line::select('applied_price', 'ivas.value as iva')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->join('categories', 'categories.id', '=', 'producttypes.category_id')
        ->join('invoices', 'invoices.id', '=', 'invoice_lines.invoice_id')
        ->join('suppliers', 'suppliers.id', '=', 'invoices.supplier_id')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->where('invoice_lines.work_id', $this->id)
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('suppliers.deleted_at')
        ->whereNULL('invoices.deleted_at')
        ->whereNULL('categories.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->get()
        ->sum(function($total){
            return $total->applied_price * (1 + ($total->iva / 100));
        });

        return $total;
    }

    public function budget_total()
    {
        $total=Budget_line::select('applied_price', 'ivas.value as iva')
        ->join('ivas', 'budget_lines.iva_id', '=', 'ivas.id')
        ->where('work_id', $this->id)
        ->whereNULL('budget_lines.deleted_at')
        ->get()
        ->sum(function($total){
            return $total->applied_price * (1 + ($total->iva / 100));
        });

        return $total;
    }

    public function already_payed($category_id)
    {
        $invoice_lines=Invoice_line::
        select('invoice_lines.*',
            'producttypes.name as producttype',
            'suppliers.id as supplier_id',
            'suppliers.name as supplier',
            'invoices.id as invoice_id',
            'invoices.name as invoice',
            'invoices.date as date',
            'invoice_payments.date as payment_date',
            'invoice_payments.value as payment')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->join('categories', 'categories.id', '=', 'producttypes.category_id')
        ->join('invoices', 'invoices.id', '=', 'invoice_lines.invoice_id')
        ->join('suppliers', 'suppliers.id', '=', 'invoices.supplier_id')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->join('invoice_payments', 'invoice_payments.invoice_line_id', '=', 'invoice_lines.id')
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('categories.id', $category_id)
        ->where('invoice_lines.work_id', $this->id)
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('invoice_payments.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('suppliers.deleted_at')
        ->whereNULL('invoices.deleted_at')
        ->whereNULL('categories.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->orderBy('invoice_payments.date', 'asc')
        ->get();

        return $invoice_lines;
    }

    public function total_already_payed()
    {
        $total=Invoice_line::
        select('invoice_lines.*',
            'producttypes.name as producttype',
            'suppliers.id as supplier_id',
            'suppliers.name as supplier',
            'invoices.id as invoice_id',
            'invoices.name as invoice',
            'invoices.date as date',
            'invoice_payments.date as payment_date',
            'invoice_payments.value as payment')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->join('categories', 'categories.id', '=', 'producttypes.category_id')
        ->join('invoices', 'invoices.id', '=', 'invoice_lines.invoice_id')
        ->join('suppliers', 'suppliers.id', '=', 'invoices.supplier_id')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->join('invoice_payments', 'invoice_payments.invoice_line_id', '=', 'invoice_lines.id')
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('invoice_lines.work_id', $this->id)
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('invoice_payments.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('suppliers.deleted_at')
        ->whereNULL('invoices.deleted_at')
        ->whereNULL('categories.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->orderBy('invoices.date', 'asc')
        ->get()
        ->sum(function($total){
            return $total->payment;
        });

        return $total;
    }

    public function total_out_of_budget()
    {
        $total=Invoice_line::select('applied_price', 'ivas.value as iva')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->join('categories', 'categories.id', '=', 'producttypes.category_id')
        ->join('invoices', 'invoices.id', '=', 'invoice_lines.invoice_id')
        ->join('suppliers', 'suppliers.id', '=', 'invoices.supplier_id')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->where('invoice_lines.work_id', $this->id)
        ->whereNull('invoice_lines.budget_line_id')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('suppliers.deleted_at')
        ->whereNULL('invoices.deleted_at')
        ->whereNULL('categories.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->get()
        ->sum(function($total){
            return $total->applied_price * (1 + ($total->iva / 100));
        });

        return $total;
    }

    public function out_of_budget_lines($category_id)
    {
        $invoice_lines=Invoice_line::
        select('invoice_lines.*',
            'producttypes.name as producttype',
            'suppliers.id as supplier_id',
            'suppliers.name as supplier',
            'invoices.id as invoice_id',
            'invoices.name as invoice',
            'invoices.date as date')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->join('categories', 'categories.id', '=', 'producttypes.category_id')
        ->join('invoices', 'invoices.id', '=', 'invoice_lines.invoice_id')
        ->join('suppliers', 'suppliers.id', '=', 'invoices.supplier_id')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('categories.id', $category_id)
        ->where('invoice_lines.work_id', $this->id)
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('suppliers.deleted_at')
        ->whereNULL('invoices.deleted_at')
        ->whereNULL('categories.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->orderBy('invoices.date', 'asc')
        ->get();

        return $invoice_lines;
    }

    public function total_unbilled_budget()
    {
        $total=Invoice_line::select('budget_lines.applied_price', 'ivas.value as iva')
        ->rightjoin('budget_lines', 'invoice_lines.budget_line_id', '=', 'budget_lines.id')
        ->join('ivas', 'ivas.id', '=', 'budget_lines.iva_id')
        ->where('budget_lines.work_id', $this->id)
        ->whereNull('invoice_lines.deleted_at')
        ->whereNull('invoice_lines.budget_line_id')
        ->whereNULL('budget_lines.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->get()
        ->sum(function($total){
            return $total->applied_price * (1 + ($total->iva / 100));
        });

        return $total;
    }

    public function unbilled_budget_lines($category_id)
    {
        $total=Invoice_line::
        select('budget_lines.applied_price',
            'ivas.value as iva',
            'producttypes.name as producttype',
            'suppliers.name as supplier',
            'budgets.name as budget',
            'budgets.date as date')
        ->rightjoin('budget_lines', 'invoice_lines.budget_line_id', '=', 'budget_lines.id')
        ->join('budgets', 'budgets.id', '=', 'budget_lines.budget_id')
        ->join('suppliers', 'suppliers.id', '=', 'budgets.supplier_id')
        ->join('ivas', 'ivas.id', '=', 'budget_lines.iva_id')
        ->join('producttypes', 'producttypes.id', '=', 'budget_lines.producttype_id')
        ->selectRaw(DB::raw('budget_lines.applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('budget_lines.work_id', $this->id)
        ->where('producttypes.category_id', $category_id)
        ->whereNull('invoice_lines.deleted_at')
        ->whereNull('invoice_lines.budget_line_id')
        ->whereNULL('budget_lines.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('suppliers.deleted_at')
        ->whereNULL('budgets.deleted_at')
        ->get();

        return $total;
    }

    public function comparation_total()
    {
        $total = $this->total_unbilled_budget() + $this->real_total();

        return $total;
    }

    public function total_in_debt()
    {
        $total = $this->real_total() - $this->total_already_payed();

        return $total;
    }

    public function in_debt($category_id)
    {
        $total = Invoice_line::select('applied_price', 'ivas.value as iva', 'producttypes.name as producttype')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('work_id', $this->id)
        ->where('category_id', $category_id)
        ->whereNull('invoice_lines.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->get();

        return $total;
    }

    public function total_payed($category_id)
    {
        return Invoice_line::select('applied_price', 'ivas.value as iva', 'producttypes.name as producttype')
        ->selectRaw('sum(invoice_payments.value) as value_payed')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('work_id', $this->id)
        ->where('category_id', $category_id)
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->groupBy('producttype', 'applied_price', 'iva')
        ->get()
        ->sum(function($total){
            return $total->value_payed;
        });

        return $total;
    }

    public function total_payments($category_id)
    {
        $total = Invoice_payment::select('value')
        ->join('invoice_lines', 'invoice_payments.invoice_line_id', '=', 'invoice_lines.id')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->where('work_id', $this->id)
        ->where('category_id', $category_id)
        ->whereNull('invoice_payments.deleted_at')
        ->whereNULL('invoice_lines.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->get()
        ->sum(function($total){
            return $total->value;
        });

        return $total;
    }

    public function total_applied_price_with_iva($category_id)
    {
        $total=Invoice_line::select('applied_price', 'ivas.value as iva')
        ->join('ivas', 'ivas.id', '=', 'invoice_lines.iva_id')
        ->join('producttypes', 'producttypes.id', '=', 'invoice_lines.producttype_id')
        ->where('work_id', $this->id)
        ->where('category_id', $category_id)
        ->whereNull('invoice_lines.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->get()
        ->sum(function($total){
            return $total->applied_price * (1 + ($total->iva / 100));
        });

        return $total;
    }

    public function budgets()
    {
        $lines = Budget_line::select('budget_lines.*',
            'producttypes.name as product',
            'budgets.ref as ref')
        ->join('budgets', 'budgets.id', '=', 'budget_lines.budget_id')
        ->join('producttypes', 'producttypes.id', '=', 'budget_lines.producttype_id')
        ->where('budget_lines.work_id', $this->id)
        ->whereNULL('budget_lines.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->whereNULL('budgets.deleted_at')
        ->whereNULL('budget_lines.invoice_line_id')
        ->get();

        return $lines;
    }
}
