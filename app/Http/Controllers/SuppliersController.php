<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Supplier;
use App\Budget;
use App\Invoice;
use App\Invoice_line;
use App\Invoice_payment;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }
    
    public function index()
    {
        $suppliers = Supplier::orderby('name')->paginate(15);

        return view('backoffice.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('backoffice.suppliers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();

        $supplier = new Supplier;
        $supplier->name = $request->name;
        $supplier->save();
    
        flash('Supplier successfully created!')->success();
    
        return redirect()->route('suppliers.index');
    }

    public function edit($supplier_id)
    {
        $supplier = Supplier::find($supplier_id);

        return view('backoffice.suppliers.edit', compact('supplier'));
    }

    public function show($supplier_id)
    {
        $supplier = Supplier::find($supplier_id);

        return view('backoffice.suppliers.show', compact('supplier'));
    }

    public function balancedetails($supplier_id)
    {
        $supplier = Supplier::find($supplier_id);

        return view('backoffice.suppliers.balancedetails', compact('supplier'));
    }

    public function update(Request $request, $supplier_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();

        $supplier = Supplier::find($supplier_id);
        $supplier->name = $request->name;
        $supplier->save();
    
        flash('Supplier successfully updated!')->success();
    
        return redirect()->route('suppliers.index');
        
    }

    public function delete($supplier_id)
    {
        Supplier::destroy($supplier_id);

        flash('Supplier successfully deleted')->success();
    
        return redirect()->route('suppliers.index');
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
        return DB::table('suppliers')->select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }

    public function search(Request $request)
    {
        $suppliers = Supplier::select('suppliers.*');

        if( $request->input('search')){
            $suppliers = $suppliers->where('name', 'LIKE', "%" . $request->search . "%")
           ;
        } 
        
        $suppliers = $suppliers->paginate(15);
        
        return view('backoffice.suppliers.index', [
            'suppliers' => $suppliers->appends(Input::except('page'))
        ]);
    }

    public function showPayments(Request $request, $supplier_id)
    {
        $supplier = Supplier::find($supplier_id);

        return view('backoffice.suppliers.payments', compact('supplier', 'request'));
    }
}
