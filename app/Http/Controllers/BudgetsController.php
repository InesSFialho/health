<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Budget;
use App\Docname;
use App\Supplier;
use App\Producttype;
use App\Iva;
use App\Budget_line;
use App\Budget_doc;
use App\Work;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

use App\Http\Requests\CompanieFormRequest;

use Illuminate\Support\Facades\Validator;

class BudgetsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }

    public function index()
    {
        $budgets = Budget::orderby('date')->paginate(15);

        return view('backoffice.budgets.index', compact('budgets'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        $works = Work::orderBy('name')->get();
        return view('backoffice.budgets.create', compact('suppliers', 'works'));
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
        $budget = new Budget;
        $budget->name = $request->name;
        $budget->date = $request->date;
        $budget->ref = $request->ref;
        $budget->work_id = $request->work_id;
        $budget->slug = $slug;
        $budget->supplier_id = $request->supplier;
        $budget->save();

        flash('Successfully created!')->success();

        return redirect()->route('budgets.index');
    }

    public function addLine($budget_id, Request $request)
    {

        $budget = new Budget_line;
        $budget->budget_id = $budget_id;
        $budget->producttype_id = $request->producttype;
        $budget->applied_price = $request->value;
        $budget->iva_id = $request->iva;
        $budget->work_id = $request->work;
        $budget->ivaDevido = $request->has('ivaDevido') ? true : false;
        $budget->outros = $request->has('outros') ? true : false;

        $budget->save();

        flash('Successfully saved!')->success();
        return redirect()->back();
    }


    public function delLine($budget_line_id)
    {
        
        Budget_line::destroy($budget_line_id);


        flash('Successfully deleted!')->success();
        return redirect()->back();
    }

    public function edit($budget_id)
    {
        $budget = Budget::find($budget_id);

        $suppliers = Supplier::orderBy('name')->get();
        $supplier = Supplier::find($budget->supplier_id);
        $works = Work::orderBy('name')->get();
        $work = Work::find($budget->work_id);
        return view('backoffice.budgets.edit', compact('budget', 'suppliers', 'supplier','works','work'));
    }

    public function show($budget_id)
    {

        $budget = Budget::find($budget_id);

       
        $supplier = Supplier::find($budget->supplier_id);
        $work = Work::find($budget->work_id);

        $docnames = Docname::orderBy('name')->get();
        $producttypes = Producttype::orderBy('name')->get();
        $ivas = Iva::all();
        $works = Work::orderBy('name')->get();


        $budget_lines = DB::table('budget_lines')->select('budget_lines.*', 'producttypes.name as producttype', 'ivas.name as iva', 'ivas.value as ivavalue','works.name as work')
            ->join('producttypes', 'budget_lines.producttype_id', '=', 'producttypes.id')
            ->join('ivas', 'budget_lines.iva_id', '=', 'ivas.id')
            ->leftJoin('works', 'budget_lines.work_id', '=', 'works.id')
            ->where('budget_id', '=', $budget_id)
            ->whereNull('budget_lines.deleted_at')
            ->get();


        $budget_docs = DB::table('budget_docs')->select('budget_docs.*', 'docnames.name as docname', 'users.name as username')
        ->join('docnames', 'budget_docs.docname_id', '=', 'docnames.id')
        ->join('users', 'budget_docs.user_id', '=', 'users.id')
        ->where('budget_id', '=', $budget_id)
        ->whereNull('budget_docs.deleted_at')
        ->get();

        return view('backoffice.budgets.show', compact('budget',  'supplier', 'work', 'docnames', 'producttypes', 'ivas', 'budget_lines', 'budget_docs', 'works'));
    }


    public function addDoc($budget_id, Request $request)
    {
        if ($request->has('upload_file')) {


            $budget_doc = new Budget_doc;
            $budget_doc->budget_id = $budget_id;
            $budget_doc->docname_id = $request->documentname_id;
            $budget_doc->note = $request->observation;

            $budget_doc->save();


            //Cria pasta se não existir 

            $path = "budgetDocs/";

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

               $filename = 'budget_doc-' . $budget_doc->id . '-' . Carbon::now()->toDateString() . '_' .  Carbon::now()->format('His') . '.'.$file->getClientOriginalExtension();
               $pathFile = $path . $dir . '/' . $filename;

              $file->move( $path . $dir, $filename);  


            $budget_doc->path =  $pathFile;
            $budget_doc->url = $path . $dir;
            $budget_doc->file = $filename;
            $budget_doc->user_id =  Auth::user()->id;

            $budget_doc->save();

            flash('Successfully saved!')->success();
            return redirect()->back();
        } else {
            flash('No File Selected')->error();
            return redirect()->back();
        }
    }


    public function delDoc($budget_doc_id)
    {
       
        Budget_doc::destroy($budget_doc_id);

        flash('Successfully deleted!')->success();
        return redirect()->back();
    }

    public function update(Request $request, $budget_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();

        $budget = Budget::find($budget_id);

        if (!empty($request->input('slug'))) {
            $tmpSlug = $request->input('slug');
        } else {
            $tmpSlug = $request->input('name');
        }

        $slug = $this->createSlug($tmpSlug, $budget->id);

        $budget->name = $request->name;
        $budget->slug = $slug;
        $budget->date = $request->date;
        $budget->ref = $request->ref;
        $budget->supplier_id = $request->supplier;
        $budget->work_id = $request->work_id;
        $budget->save();

        flash('Successfully updated!')->success();

        return redirect()->route('budgets.index');
    }

    public function delete($budget_id)
    {
        Budget::destroy($budget_id);

        flash('Budget successfully deleted')->success();

        return redirect()->route('budgets.index');
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
        return DB::table('budgets')->select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }

    public function search(Request $request)
    {
        $budgets = Budget::select('budgets.*');

        if( $request->input('search')){
            $budgets = $budgets->where('name', 'LIKE', "%" . $request->search . "%")
            ->orWhere('ref', 'LIKE', "%" . $request->search . "%")
           ;
        } 
        
        $budgets = $budgets->paginate(15);
        
        return view('backoffice.budgets.index', [
            'budgets' => $budgets->appends(Input::except('page'))
        ]);
    }
}
