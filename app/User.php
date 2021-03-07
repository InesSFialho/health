<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;
use App\Project;
use App\PathologyUser;



class User extends Authenticatable implements MustVerifyEmail
{

    use LaratrustUserTrait;
    use Notifiable;
    use SoftDeletes;


   
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'last_login', 'role_id', 'lang'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    
    
    public function hasPermissionsOrRole($permissions_array)
    {
        foreach ($permissions_array as $permission) {
            $roles = Role::whereIn('id', Permission_role::whereIn('permission_id',
                Permission::where('name', $permission)->pluck('id')->toarray()
            )->pluck('role_id')->toarray())->get();

            if (!$this->hasAnyRole($roles ?? []) && !$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    

    public function hasAnyPermissionsOrRole($permissions_array)
    {
        foreach ($permissions_array as $permission) {

            $roles = Role::whereIn('id', Permission_role::whereIn(
                'permission_id',
                Permission::where('name', $permission)->pluck('id')->toarray()
            )->pluck('role_id')->toarray())->get();

            if ($this->hasAnyRole($roles) || $this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }
    

    public function hasAnyRole($roles_array)
    {
        foreach ($roles_array as $role) {
            if ($this->hasRole($role->name))
                return true;
        }
        return false;
    }
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
        // Notification::send($user, new \App\Notifications\MailResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\CustomVerifyEmail);
    }

    public function _pathologies()
    {
        $pathologies = PathologyUser::select(
            'pathologies.*',
            'pathology_users.have')
        ->join('pathologies', 'pathologies.id', '=', 'pathology_users.pathology_id')
        ->where('user_id', $this->id)
        ->where('pathology_users.have', 1)
        ->get();

        return $pathologies;
    }

    public function pathologies()
    {
        $pathologies = PathologyUser::select(
            'pathologies.*',
            'pathology_users.have')
        ->join('pathologies', 'pathologies.id', '=', 'pathology_users.pathology_id')
        ->where('user_id', $this->id)
        // ->where('pathology_users.have', 1)
        ->get();

        return $pathologies;
    }

    function allowed_recipes()
    {
        $not_allowed_recipe_ids = PathologyRecipe::select('pathology_recipes.recipe_id', 'pathology_recipes.pathology_id')
        ->where('pathology_recipes.allowed', 0)
        ->whereNULL('pathology_recipes.deleted_at')
        ->distinct()
        ->get('pathology_recipes.recipe_id', 'pathology_recipes.pathology_id');

        $recipes = [];

        foreach ($this->_pathologies() as $pathology) {
            foreach ($not_allowed_recipe_ids as $recipe) {
                if ($recipe->pathology_id == $pathology->id) {
                    $recipes[] = $recipe->recipe_id;
                }
            }
        }
        
        $allowed_recipes = Recipe::whereNotIn('id', $recipes)->get();

        return $allowed_recipes;
    }
}
