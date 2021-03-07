<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

use App\Work;
use App\Category;



use Illuminate\Support\Facades\Validator;

class WorksController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }
    
    public function index()
    {
        $opened_works = Work::where('opened', 1)
        ->orderBy('id')
        ->get();
        
        $closed_works = Work::where('opened', 0)
        ->orderBy('id')
        ->get();

        return view('backoffice.works.index', compact('opened_works', 'closed_works'));
    }

    public function create()
    {
        return view('backoffice.works.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();

        $work = new Work;
        $work->name = $request->name;
        $work->value = $request->value;
        $work->save();
    
        flash('Work successfully created!')->success();
    
        return redirect()->route('works.index');
    }

    public function edit($work_id)
    {
        $work = Work::find($work_id);

        return view('backoffice.works.edit', compact('work'));
    }

    public function update(Request $request, $work_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();

        $work = Work::find($work_id);
        $work->name = $request->name;
        $work->value = $request->value;
        $work->save();
    
        flash('Work successfully updated!')->success();
    
        return redirect()->route('works.index');
    }

    public function delete($work_id)
    {
        Work::destroy($work_id);

        flash('Work successfully deleted')->success();
    
        return redirect()->route('works.index');
    }

    public function show($work_id)
    {
        $work = Work::find($work_id);
        $categories = Category::orderBy('name')->get();

        return view('backoffice.works.show', compact('work','categories'));
    }

    public function real($work_id)
    {
        $work = Work::find($work_id);
        $categories = Category::orderBy('name')->get();

        return view('backoffice.works.real', compact('work','categories'));
    }

    public function payed($work_id)
    {
        $work = Work::find($work_id);
        $categories = Category::orderBy('name')->get();

        return view('backoffice.works.payed', compact('work','categories'));
    }

    public function toPay($work_id)
    {
        $work = Work::find($work_id);
        $categories = Category::orderBy('name')->get();

        return view('backoffice.works.to-pay', compact('work','categories'));
    }

    public function outOfBudget($work_id)
    {
        $work = Work::find($work_id);
        $categories = Category::orderBy('name')->get();

        return view('backoffice.works.out-of-budget', compact('work','categories'));
    }

    public function unbilledBudget($work_id)
    {
        $work = Work::find($work_id);
        $categories = Category::orderBy('name')->get();

        return view('backoffice.works.unbilled-budget', compact('work','categories'));
    }

    public function budget($work_id)
    {
        $work = Work::find($work_id);
        $categories = Category::orderBy('name')->get();

        return view('backoffice.works.budget', compact('work','categories'));
    }


    public function comparation($work_id)
    {
        $work = Work::find($work_id);
        $categories = Category::orderBy('name')->get();

        return view('backoffice.works.comparation', compact('work','categories'));
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
        return DB::table('works')->select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }


    public function search(Request $request)
    {
        $works = Work::select('works.*');

        if( $request->input('search')){
            $works = $works->where('name', 'LIKE', "%" . $request->search . "%")
           ;
        } 
        
        $works = $works->paginate(15);
        
        return view('backoffice.works.index', [
            'works' => $works->appends(Input::except('page'))
        ]);
    }

    public function statusUpdate($work_id)
    {
        $work = Work::find($work_id);
        $work->opened = $work->opened == 0 ? 1 : 0;
        $work->save();

        return redirect()->route('works.index');

    }
}
