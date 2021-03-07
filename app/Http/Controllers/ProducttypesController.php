<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Producttype;
use App\Supplier;
use Illuminate\Support\Facades\Input;

use App\Http\Requests\CompanieFormRequest;

use Illuminate\Support\Facades\Validator;

class ProducttypesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }
    
    public function index()
    {
        $producttypes = Producttype::orderby('name')->paginate(15);

        return view('backoffice.producttypes.index', compact('producttypes'));
    }

    public function create()
    {
        $categories = DB::table('categories')->whereNull('deleted_at')->pluck('name', 'id');

        return view('backoffice.producttypes.create', compact('categories'));
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

        $producttype = new Producttype;
        $producttype->name = $request->name;
        $producttype->slug = $slug;
        $producttype->category_id = $request->categories;
        $producttype->save();
    
        flash('Successfully created!')->success();
    
        return redirect()->route('producttypes.index');
    }

    public function edit($producttype_id)
    {
        $producttype = Producttype::find($producttype_id);
        $categories = DB::table('categories')->whereNull('deleted_at')->pluck('name', 'id');
        return view('backoffice.producttypes.edit', compact('producttype', 'categories'));
    }

    public function update(Request $request, $producttype_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();


        $producttype = Producttype::find($producttype_id);
        
        if (!empty($request->input('slug'))) {
            $tmpSlug = $request->input('slug');
        } else {
            $tmpSlug = $request->input('name');
        }

        $slug = $this->createSlug($tmpSlug, $producttype->id);

        $producttype->name = $request->name;
        $producttype->slug = $slug;
        $producttype->category_id = $request->categories;
        $producttype->save();
    
        flash('Successfully updated!')->success();
    
        return redirect()->route('producttypes.index');
        
    }

    public function delete($producttype_id)
    {
        Producttype::destroy($producttype_id);

        flash('Successfully deleted!')->success();
    
        return redirect()->route('producttypes.index');
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
        return DB::table('producttypes')->select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }


    public function search(Request $request)
    {
        $producttypes = Producttype::select('producttypes.*');

        if( $request->input('search')){
            $producttypes = $producttypes->where('name', 'LIKE', "%" . $request->search . "%")
           ;
        } 
        
        $producttypes = $producttypes->paginate(15);
        
        return view('backoffice.producttypes.index', [
            'producttypes' => $producttypes->appends(Input::except('page'))
        ]);
    }
}
