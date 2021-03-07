<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Invoice_line;
use App\Budget_line;
use App\Work;
use App\Supplier;
use DB;

class InvoiceLinesController extends Controller
{
    public function edit($supplier_id, $line_id, $work_id)
    {
        
        $budgets = Budget_line::select('budget_lines.id',
            'budgets.name',
            'budget_lines.applied_price',
            'ivas.value',
            'producttypes.name as product')
        ->join('budgets', 'budgets.id', '=', 'budget_lines.id')
        ->join('ivas', 'budget_lines.iva_id', '=', 'ivas.id')
        ->join('producttypes', 'budget_lines.producttype_id', '=', 'producttypes.id')
        ->selectRaw(DB::raw('applied_price*(1+ivas.value/100) AS applied_price_with_iva'))
        ->where('budget_lines.work_id', $work_id)
        ->whereNull('budget_lines.deleted_at')
        ->whereNULL('budgets.deleted_at')
        ->whereNULL('ivas.deleted_at')
        ->whereNULL('producttypes.deleted_at')
        ->get();


        $work = Work::find($work_id);

        return view('backoffice.suppliers.budget', compact('budgets', 'work', 'line_id', 'supplier_id'));
    }

    public function update($supplier_id, Request $request)
    {
        $supplier = Supplier::find($supplier_id);

        $line = Invoice_line::find($request->invoice_line_id);

        $budget_line = Budget_line::find($line->budget_line_id);
        $budget_line->invoice_line_id = null;
        $budget_line->save();

        $line->budget_line_id = $request->budget_line_id;
        $line->save();

        $budget_line = Budget_line::find($request->budget_line_id);
        $budget_line->invoice_line_id = $request->invoice_line_id;
        $budget_line->save();

        flash('Successfully updated!')->success();
        return view('backoffice.suppliers.balancedetails', compact('supplier'));
    }
}
