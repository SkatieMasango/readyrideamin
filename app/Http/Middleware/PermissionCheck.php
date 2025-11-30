<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
       $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    $myRole = $user->roles()->first(); // Assumes single role

    if (!$myRole) {
        return back()->with('error', 'No role assigned.');
    }

    // Get all permission IDs from role_has_permissions
    $permissionIds = DB::table('role_has_permissions')
        ->where('role_id', $myRole->id)
        ->pluck('permission_id');

    // Get permission names from permissions table
    $permissionNames = DB::table('permissions')
        ->whereIn('id', $permissionIds)
        ->pluck('name')
        ->toArray();

    $requestRoute = $request->route()->getName();
    // Check if route is allowed
    if (in_array($requestRoute, $permissionNames) || $myRole->name === 'root') {
        return $next($request);
    }

    return back()->with('error', 'Sorry, You have no permission to access this route.');
    }
}
