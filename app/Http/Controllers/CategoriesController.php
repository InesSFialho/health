<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Category;
use App\Supplier;
use Illuminate\Support\Facades\Input;

use App\Http\Requests\CompanieFormRequest;

use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }
    
    public function index()
    {
        $categories = Category::orderby('name')->paginate(15);

        return view('backoffice.categories.index', compact('categories'));
    }

    public function create()
    {
       
        return view('backoffice.categories.create');
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

        if (!empty($request->input('sort'))){
            $sort = $request->input('sort');
        } else {
            $tmpSort = DB::table('categories')->select('sort')
            ->orderBy('sort', 'desc')
            ->first();
            if ($tmpSort== null){
                $sort = 1;
            } else {
                $sort = $tmpSort->sort + 1;
            }
        }


        $category = new Category;
        $category->name = $request->name;
        $category->slug = $slug;
        $category->sort = $sort;
        $category->save();
    


// SORT - ordenar


$finalOrders =  DB::table('categories')->select( 'id as id')
->whereNull('deleted_at')->orderBy('sort', 'asc')->orderBy('updated_at', 'desc')->get();

$i = 1;
foreach ($finalOrders as $finalOrder) {
DB::table('categories')->where('id', '=', $finalOrder->id)
->update(['sort' => $i]);
$i++;
}

//////
        flash('Successfully created!')->success();
    
        return redirect()->route('categories.index');
    }

    public function edit($category_id)
    {
        $category = Category::find($category_id);
        return view('backoffice.categories.edit', compact('category'));
    }

    public function update(Request $request, $category_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();


        $category = Category::find($category_id);
        
        if (!empty($request->input('slug'))) {
            $tmpSlug = $request->input('slug');
        } else {
            $tmpSlug = $request->input('name');
        }

        $slug = $this->createSlug($tmpSlug, $category->id);



        if (!empty($request->input('sort'))){
            $sort = $request->input('sort');
        } else {
            $tmpSort = DB::table('categories')->select('sort')
            ->orderBy('sort', 'desc')
            ->first();
            if ($tmpSort== null){
                $sort = 1;
            } else {
                $sort = $tmpSort->sort + 1;
            }
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->sort = $sort;
        $category->save();
    


// SORT - ordenar


$finalOrders =  DB::table('categories')->select( 'id as id')
->whereNull('deleted_at')->orderBy('sort', 'asc')->orderBy('updated_at', 'desc')->get();

$i = 1;
foreach ($finalOrders as $finalOrder) {
DB::table('categories')->where('id', '=', $finalOrder->id)
->update(['sort' => $i]);
$i++;
}

//////
        flash('Successfully updated!')->success();
    
        return redirect()->route('categories.index');
        
    }

    public function delete($category_id)
    {
        Category::destroy($category_id);

        flash('Successfully deleted!')->success();
    
        return redirect()->route('categories.index');
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
        return DB::table('categories')->select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }


    public function search(Request $request)
    {
        $categories = Category::select('categories.*');

        if( $request->input('search')){
            $categories = $categories->where('name', 'LIKE', "%" . $request->search . "%")
           ;
        } 
        
        $categories = $categories->paginate(15);
        
        return view('backoffice.categories.index', [
            'categories' => $categories->appends(Input::except('page'))
        ]);
    }
}
