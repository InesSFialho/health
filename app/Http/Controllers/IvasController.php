<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

use App\Work;
use App\Category;
use App\Iva;
use App\Invoice;


class IvasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }
    
    public function index()
    {
        $records = Invoice::all();

        return view('backoffice.ivas.index', compact('records'));
    }

    public function show(Request $request)
    {
        $year = $request->get('year');
        $trimester = $request->get('trimester');

        $records = Invoice::all();
        
        return view('backoffice.ivas.show', compact('year','trimester', 'records'));
    }

    public function real($work_id)
    {
        $work = Work::find($work_id);
        $categories = Category::all();

        return view('backoffice.ivas.real', compact('work','categories'));
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
        return DB::table('ivas')->select('slug')->where('slug', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }


    public function search(Request $request)
    {
        $ivas = Work::select('ivas.*');

        if( $request->input('search')){
            $ivas = $ivas->where('name', 'LIKE', "%" . $request->search . "%")
           ;
        } 
        
        $ivas = $ivas->paginate(15);
        
        return view('backoffice.ivas.index', [
            'ivas' => $ivas->appends(Input::except('page'))
        ]);
    }
}
