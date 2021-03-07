<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Kris\LaravelFormBuilder\FormBuilderTrait;

use App\Forms\PermissionForm;

use App\Role;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    use FormBuilderTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }
	
    public function index()
    {
        $roles = Role::all();
        return view('backoffice.roles.index', compact('roles'));
    }   

    public function create()
    {
       return view('backoffice.roles.create');
    }

    public function store(Request $request)
    {
        $result = true;
        $form = $this->form(PermissionForm::class);
        
        $validator = Validator::make($request->all(), [
            'display_name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            flash('Fill the fields!')->error();
            return redirect('backoffice/roles/create')
                        ->withErrors($validator)
                        ->withInput();
        }


        if (!empty($request->input('name'))){
            $tmpSlug = $request->input('name');
        } else {
            $tmpSlug = $request->input('display_name');
        }

        $name = $this->createSlug($tmpSlug, 0);


        $result = DB::table('roles')->insert([
            ['display_name' => $request->input('display_name'), 'is_active' =>  $request['is_active']==1 ? 1: 0, 'name' => $name, 'description' =>  $request['msg'],  'created_at' => now()]
        ]);
        
        if($result):
            flash(__('Permissão criada com sucesso!'))->success();
        else:
            flash(__('Ocurreu um erro ao criar a permissão!'))->error();
        endif;

        return redirect()->route('backoffice.roles.index');
    }

    public function edit( $id)
    {
        
        $roles = DB::table('roles')->where('id',  $id)->first();
        return view('backoffice.roles.edit', compact('roles'));
    }

    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'dipslay_name' => 'required|max:255'
        ]);


        $result = DB::table('roles')->where('id',  $id)->update(['display_name' => $request->input('display_name'), 'is_active' =>  $request['is_active']==1 ? 1: 0,  'description' =>  $request['msg'], 'updated_at' => now()]);

        if($result):
            flash(__('Updated!'))->success();
        else:
            flash(__('Error updating!'))->error();
        endif;

        return redirect()->route('backoffice.roles.index');
    }

    public function delete(Role $role)
    {
        $result = true;

        try {
            DB::beginTransaction();

            $role->delete();

            DB::commit();
            $result = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $result = false;
        }

        if($result):
            flash(__('Permissão eliminada com sucesso!'))->success();
        else:
            flash(__('Ocurreu um erro ao eliminar a permissão!'))->error();
        endif;
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
        for ($i = 1; $i <= 10; $i++) {
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
}
