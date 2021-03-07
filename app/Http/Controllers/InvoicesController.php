<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Invoice;
use App\Docname;
use App\Producttype;
use App\Iva;
use App\Supplier;
use App\Work;
use App\Invoice_line;
use App\Invoice_doc;
use App\Invoice_payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use App\Http\Requests\CompanieFormRequest;

use Illuminate\Support\Facades\Validator;

class InvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }

    public function index()
    {
        $invoices = Invoice::orderby('date')->paginate(15);

        return view('backoffice.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $works = Work::orderBy('name')->get();
        return view('backoffice.invoices.create', compact('works', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();


        if (!empty($request->input('slug'))) {
            $tmpSlug = $request->input('slug');
        } else {
            $tmpSlug = $request->input('name');
        }

        $slug = $this->createSlug($tmpSlug, 0);

        $invoice = new Invoice;
        $invoice->name = $request->name;
        $invoice->date = $request->date;
        $invoice->ref = $request->ref;
        $invoice->slug = $slug;
        $invoice->supplier_id = $request->supplier;
        $invoice->save();

        flash('Successfully created!')->success();

        return redirect()->route('invoices.index');
    }

    public function edit($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        $works = Work::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $supplier = Supplier::find($invoice->supplier_id);
        $work = Work::find($invoice->work_id);
        return view('backoffice.invoices.edit', compact('invoice', 'suppliers', 'supplier', 'works','work'));
    }

    public function update(Request $request, $invoice_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();

        $invoice = Invoice::find($invoice_id);

        if (!empty($request->input('slug'))) {
            $tmpSlug = $request->input('slug');
        } else {
            $tmpSlug = $request->input('name');
        }

        $slug = $this->createSlug($tmpSlug, $invoice->id);

        $invoice->name = $request->name;
        $invoice->slug = $slug;
        $invoice->date = $request->date;
        $invoice->ref = $request->ref;
        $invoice->supplier_id = $request->supplier;
        $invoice->save();

        flash('Successfully updated!')->success();

        return redirect()->route('invoices.index');

    }

    public function delete($invoice_id)
    {
        Invoice::destroy($invoice_id);

        flash('Invoice successfully deleted')->success();

        return redirect()->route('invoices.index');
    }

    public function show($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        $supplier = Supplier::find($invoice->supplier_id);

        $work = Work::find($invoice->work_id);

        $docnames = Docname::orderBy('name')->get();
        $producttypes = Producttype::orderBy('name')->get();
        $ivas = Iva::all();

        $works = Work::orderBy('name')->get();

        return view('backoffice.invoices.show', compact('invoice',  'supplier', 'work', 'docnames','producttypes','ivas', 'works'));
    }


    public function addDoc($invoice_id, Request $request)
    {
        if ($request->has('upload_file')) {


            $invoice_doc = new Invoice_doc;
            $invoice_doc->invoice_id = $invoice_id;
            $invoice_doc->docname_id = $request->documentname_id;
            $invoice_doc->note = $request->observation;

            $invoice_doc->save();


            //Cria pasta se não existir

            $path = "invoiceDocs/";

            $month = date("m");
            $year = date("Y");
            $day = date("d");

            if (!is_dir($path)) {
                mkdir($path);
            }

            $dir = $path . '/' . $year;

            if (!is_dir($path . $year)) {
                mkdir($path . $year);
            }

            $dir = $year . '/' . $month;

            if (!is_dir($path . $dir)) {
                mkdir($path . $dir);
            }

            $dir = $year . '/' . $month . '/' . $day;

            if (!is_dir($path . $dir)) {
                mkdir($path . $dir);
            }

               $file = $request->file('upload_file');

               $filename = 'invoice_doc-' . $invoice_doc->id . '-' . Carbon::now()->toDateString() . '_' .  Carbon::now()->format('His') . '.'.$file->getClientOriginalExtension();
               $pathFile = $path . $dir . '/' . $filename;

              $file->move( $path . $dir, $filename);


            $invoice_doc->path =  $pathFile;
            $invoice_doc->url = $path . $dir;
            $invoice_doc->file = $filename;
            $invoice_doc->user_id =  Auth::user()->id;

            $invoice_doc->save();

            flash('Successfully saved!')->success();
            return redirect()->back();
        } else {
            flash('No File Selected')->error();
            return redirect()->back();
        }
    }


    public function delDoc($invoice_doc_id)
    {

        Invoice_doc::destroy($invoice_doc_id);

        flash('Successfully deleted!')->success();
        return redirect()->back();
    }


    public function addLine($invoice_id, Request $request)
    {

        $invoice = new Invoice_line;
        $invoice->invoice_id = $invoice_id;
        $invoice->producttype_id = $request->producttype;
        $invoice->applied_price = $request->value;
        $invoice->iva_id = $request->iva;
        $invoice->work_id = $request->work;
        $invoice->ivaDevido = $request->has('ivaDevido') ? true : false;
        $invoice->outros = $request->has('outros') ? true : false;

        $invoice->save();


        flash('Successfully created!')->success();
        return redirect()->back();
    }


    public function delLine($invoice_line_id)
    {

        Invoice_line::destroy($invoice_line_id);

        flash('Successfully deleted!')->success();
        return redirect()->back();
    }


    public function addPayment($invoice_id, Request $request)
    {

        $invoice = new Invoice_payment;
        $invoice->invoice_id = $invoice_id;
        $invoice->value = $request->value;
        $invoice->user_id =  Auth::user()->id;
        $invoice->save();

        flash('Successfully created!')->success();
        return redirect()->back();
    }

    public function updatePayment( Request $request)
    {
        $payment = Invoice_payment::find($request['payment_id']);
        $payment->value = $request['payment_value'];
        $payment->save();

        flash('Successfully updated!')->success();
        return redirect()->back();
    }


    public function updateLine(Request $request)
    {
        $line = Invoice_line::findOrFail($request->line_id);
        $line->producttype_id = $request->producttype;
        $line->applied_price = $request->value;
        $line->iva_id = $request->iva;
        $line->work_id = $request->work;
        $line->ivaDevido = $request->has('ivaDevido') ? true : false;
        $line->outros = $request->has('outros') ? true : false;
        $line->save();

        flash('Successfully updated!')->success();
        return redirect()->back();
    }

    public function delPayment($invoice_payment_id)
    {

        Invoice_payment::destroy($invoice_payment_id);

        flash('Successfully deleted!')->success();
        return redirect()->back();
    }


    public function createSlug($title, $id)
    {
        // Normalize the title
        $slug = str_slug($title);
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        // If we haven't used it before then we are all good.
        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 50; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }

    protected function getRelatedSlugs($slug, $id)
    {
        return DB::table('invoices')->select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }



    public function search(Request $request)
    {
        $invoices = Invoice::select('invoices.*')->leftJoin('suppliers', 'invoices.supplier_id', '=', 'suppliers.id')->orderByDesc('created_at');


        if( $request->input('search')){
            $invoices = $invoices->where('invoices.ref', 'LIKE', "%" . $request->search . "%")
            ->orWhere('invoices.name', 'LIKE', "%" . $request->search . "%")
            ->orWhere('suppliers.nif', 'LIKE', "%" . $request->search . "%")
            ->orWhere('suppliers.name', 'LIKE', "%" . $request->search . "%");
        }

        $invoices = $invoices->paginate(15);

        return view('backoffice.invoices.index', [
            'invoices' => $invoices->appends(Input::except('page'))
        ]);
    }

}
