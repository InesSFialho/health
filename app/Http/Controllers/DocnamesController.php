<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Docname;

use Illuminate\Support\Facades\Input;


use Illuminate\Support\Facades\Validator;

class DocnamesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }
    
    public function index()
    {
        $docnames = Docname::paginate(15);

        return view('backoffice.docnames.index', compact('docnames'));
    }

    public function create()
    {
       
        return view('backoffice.docnames.create');
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

        $docname = new Docname;
        $docname->name = $request->name;
        $docname->slug = $slug;
        $docname->save();
    
        flash('Successfully created!')->success();
    
        return redirect()->route('docnames.index');
    }

    public function edit($docname_id)
    {
        $docname = Docname::find($docname_id);
        return view('backoffice.docnames.edit', compact('docname'));
    }

    public function update(Request $request, $docname_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();


        $docname = Docname::find($docname_id);
        
        if (!empty($request->input('slug'))) {
            $tmpSlug = $request->input('slug');
        } else {
            $tmpSlug = $request->input('name');
        }

        $slug = $this->createSlug($tmpSlug, $docname->id);

        $docname->name = $request->name;
        $docname->slug = $slug;
        $docname->save();
    
        flash('Successfully updated!')->success();
    
        return redirect()->route('docnames.index');
        
    }

    public function delete($docname_id)
    {
        Docname::destroy($docname_id);

        flash('Successfully deleted!')->success();
    
        return redirect()->route('docnames.index');
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
        return DB::table('docnames')->select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }


    public function search(Request $request)
    {
        $docnames = Docname::select('docnames.*');

        if( $request->input('search')){
            $docnames = $docnames->where('name', 'LIKE', "%" . $request->search . "%")
           ;
        } 
        
        $docnames = $docnames->paginate(15);
        
        return view('backoffice.docnames.index', [
            'docnames' => $docnames->appends(Input::except('page'))
        ]);
    }
}
