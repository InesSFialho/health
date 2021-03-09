<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Forms\ChangePasswordForm;
use App\Forms\UserForm;

use App\Rules\CanCreateUser;

use App\User;
use App\Role;
use App\Company;
use App\Permission;
use App\Permission_user;
use App\PathologyUser;
use App\Pathology;
use Session;
use Cache;


class UsersController extends Controller
{
    

    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }
	
    public function index()
    {        
        $users = User::all();

    	return view('backoffice.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $companies = Company::all();

        return view('backoffice.users.create', compact('roles','permissions','companies'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email|email',
            'company' => 'required|integer|exists:companies,id',
            'role' => 'required|integer|exists:roles,id'
        ])->validate();

        $user = new User;
        $user->name = $request->name;
        $user->role_id = $request->role;
        $user->email = $request->email;
        $user->is_active = '1';

        $user->password = bcrypt('QWERTY123');
        $user->company()->associate($request->company);
        $user->save();

        $user->roles()->attach($request->role);
       
        if($request->role == 1){
            $user->permissions()->attach(Permission::all());
        } else {
            $user->roles()->sync($request->role);
            $user->permissions()->sync($request->input('permissions_user'));
        }

        $pathologies = Pathology::all();

        if (!$pathologies->isEmpty()) {
            foreach ($pathologies as $pathology) {
                $pivot = new PathologyUser;
                $pivot->pathology_id = $pathology->id;
                $pivot->user_id = $user->id;
                $pivot->save();
            }
        }

        flash('User successfully created!')->success();

        return redirect()->route('backoffice.users.index');
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);
        $companies = Company::all();
        $roles = Role::all();
        
        $permissions_user = Permission_user::where('user_id', $user->id)->pluck('permission_id')->toArray();

        $permissions = Permission::all();

        return view('backoffice.users.edit', compact('user', 'roles','permissions', 'permissions_user','companies' ));
    }

    public function update(Request $request, $user_id)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' =>  'required|email|unique:users,email,'. $user_id .'',
            'company' => 'required|integer|exists:companies,id',
            'role' => 'required|integer|exists:roles,id'
        ])->validate();
        
        $user = User::find($user_id);
        $user->name = $request->name;
        $user->role_id = $request->role;
        $user->email = $request->email;
        $user->company()->associate($request->company);
        $user->is_active = $request->has('is_active') ? true : false;
        $user->save();

        $roles = Role::all();
        $admin_count = $roles[0]->users()->count();

        $admin = 1;
        $client = 2;
       
        if ($request->role != $client) {
   
            $user->roles()->sync($admin);
              
            $user->permissions()->sync(Permission::all());
        } else {
            if ($request->user == 1 && $admin_count >= 1) {
                flash("You are the only administrator in the system, you cannot change your role to 'client'!")->error();
                return redirect()->back();
            } else {
                $user->roles()->sync($client);
                $user->permissions()->sync([]);
            }
        }
            
        flash('User successfully updated!')->success();

        return redirect()->route('backoffice.users.index');
    }

    public function locale(Request $request, $user_id)
    {
        $user = User::find($user_id);
        $user->lang = $request->lang;
        $user->save();

        Session::put('locale', $request->lang);

        return redirect()->back();
    }

    public function password(Request $request, $user_id)
    {
        if(Hash::check($request->current, Auth::user()->password)){
            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:8|string'
            ]);

            if ($validator->fails())
            {
                flash('The password confirmation does not match!')->error();
                return redirect()->back()->withErrors($validator->errors());
            }

        } else {
            flash('Current password incorrect!')->error();
            return redirect()->back();
        }

        $user = User::find($user_id);
        $user->password = bcrypt($request->password);
        $user->save();

        flash('Password successfully updated!')->success();
    
        return redirect()->back();
    }

    public function destroy($user_id)
    {
        User::destroy($user_id);

        flash('User successfully deleted!')->success();
    
        return redirect()->route('backoffice.users.index');
    }


    public function pass(User $user)
    {
        
                return view('backoffice.users.pass', compact('user'));
    }

    public function passstore(Request $request)
    {

        try {
            DB::beginTransaction();

            // $user = User::find($request->id);
            // $user->password = Hash::make($request->password);
            // dd($request->password .' - ' .$user->password);
            // $user->update();
            $user = User::find($request->id);
            $user->password = bcrypt($request->password);
            $user->save();

            DB::commit();
            $result = true;
        } catch (\Exception $e) {
            DB::rollBack();
            $result = false;
        }

        if ($result) :
            flash('Password changed!')->success();
        else :
            flash('There was an error changing your password!')->error();
        endif;


        return redirect()->route('backoffice.users.index');
    }

    
    public function userOnlineStatus()
    {
        $users = User::all();

        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id))
                echo $user->name . " is online. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
            else
                echo $user->name . " is offline. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
        }
    }

    public function showHealth($user_id)
    {
        $user = User::find($user_id);
        
        return view('backoffice.users.pathologies', compact('user'));
    }

    public function updateHealth($user_id, $pathology_id)
    {
        $pivot = PathologyUser::where('user_id', $user_id)
        ->where('pathology_id', $pathology_id)
        ->first();

        $pivot->have = $pivot->have == 0 ? 1 : 0;
        $pivot->save();

        return redirect()->back();
    }
}