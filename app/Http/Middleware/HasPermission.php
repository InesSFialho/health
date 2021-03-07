<?php

namespace App\Http\Middleware;

use App\Permission;
use App\Permission_role;
use App\Role;
use Closure;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions_array)
    {
        if ($request->user() != null && $request->user()->hasPermissionsOrRole($permissions_array)) {
            return $next($request);
        } else {
            flash()->overlay(__('Não tem permissões para efetuar essa ação'), 'Info');
            return redirect()->back();
        }
        flash()->overlay(__('Não tem permissões para efetuar essa ação'), 'Info');
        return redirect()->back();
    }
}
  