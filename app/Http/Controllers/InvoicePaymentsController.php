<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice_payment;

class InvoicePaymentsController extends Controller
{
    public function create($line_id)
    {
        return redirect()->with(['line'=> $line]);
    }

    public function store(Request $request)
    {
        $payment = new Invoice_payment;
        $payment->invoice_line_id = $request->invoice_line_id;
        $payment->user_id = auth()->user()->id;
        $payment->value = $request->value;
        $payment->save();

        flash('Successfully updated!')->success();
        return redirect()->back();
    }
}
