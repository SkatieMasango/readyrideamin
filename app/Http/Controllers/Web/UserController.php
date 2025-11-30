<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
        $query->whereIn('name', ['driver', 'rider']);
        })->get();

        $users = $this->paginateCollection($users, 10);
        return view('user.index', compact('users'));
    }
    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */

    public function create(){
        $countries = Country::all();
        $roles = Role::all();
        $roles = Role::all()->pluck('name', 'id')->map(fn($name, $id) => [
            'value' =>$name,
            'name' => $name,
        ])->values()->toArray();

        return view('user.create',compact('countries','roles'));
    }
    public function store(Request $request)
    {
        $country = Country::where('phone_code', $request->phone_code)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'phone_number' => 'required|phone:' . strtoupper($country->code),
            ], [
                'phone_number.phone' => 'The phone number is not valid for the selected country.',

        ]);

        $phoneCode = $request->phone_code;
        $phoneNumber = $request->phone_number;

        if (Str::endsWith($phoneCode, '0') && Str::startsWith($phoneNumber, '0')) {
            $phoneNumber = substr($phoneNumber, 1);
        }

        $fullMobile = $phoneCode . $phoneNumber;
        $password =  Hash::make($request->password) ;

        // Update user details
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email ?? '',
            'country_iso' => $country->code ?? '',
            'gender' => $request->gender ?? '',
            'address' => $request->address ?? '',
            'mobile' => $fullMobile,
            'status' => $request->status ?? '',
            'password' => $password,
        ]);
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User saved successfully!');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $countries = Country::all();
        $iso = Country::where('code', $user->country_iso)->first();
         $roles = Role::all()->pluck('name', 'id')->map(fn($name, $id) => [
            'value' =>$name,
            'name' => $name,
        ])->values()->toArray();

        return view('user.edit',compact('user','countries','iso','roles'));
    }
    public function update(Request $request, $id)
    {
        $country = Country::where('phone_code', $request->phone_code)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'phone_number' => 'required|phone:' . strtoupper($country->code),
            ], [
                'phone_number.phone' => 'The phone number is not valid for the selected country.',

        ]);

        $phoneCode = $request->phone_code;
        $phoneNumber = $request->phone_number;

        if (Str::endsWith($phoneCode, '0') && Str::startsWith($phoneNumber, '0')) {
            $phoneNumber = substr($phoneNumber, 1);
        }

        $fullMobile = $phoneCode . $phoneNumber;
        // $password =  Hash::make($request->password) ;

        $user = User::find($id);
        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email ?? '',
            'country_iso' => $country->code ?? '',
            'gender' => $request->gender ?? '',
            'address' => $request->address ?? '',
            'mobile' => $fullMobile,
            'status' => $request->status ?? '',
            // 'password' => $password,
        ]);

        $role = Role::where('name', $request->role)->firstOrFail();

        $user->syncRoles([$role->name]);

        $permissionIds = DB::table('role_has_permissions')
        ->where('role_id', $role->id)
        ->pluck('permission_id');

        $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name');
        $user->syncPermissions($permissionNames);

        return redirect()->back()->with('success', 'User Update successfully!');
    }

    public function destroy( $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted!');
    }

    public function roleIndex(){

        $roles = Role::whereNotIn('name', ['root', 'driver', 'rider'])->get();

        return view('user.user-roles', compact('roles'));
    }

    public function roleCreate(){
        $permissions = Permission::all();
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });

        return view('user.user-roles-create',compact('groupedPermissions'));
    }
    public function rolePermissionStore(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Update user details
        $role =Role::create([
            'name' => strtolower($request->title),
            'guard_name' => 'web',
        ]);

        $permissions = $request->input('permissions');
        $role->permissions()->sync($permissions);


        return redirect()->route('management.user-roles.index')->with('success', 'User saved successfully!');
    }
    public function roleEdit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
    });
        return view('user.user-roles-edit',compact('groupedPermissions','role'));
    }

    public function rolePermissionUpdate(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        $permissions = $request->input('permissions');

        $role->permissions()->sync($permissions);

        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }

    private function paginateCollection(Collection $data, int $perPage): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Get current page
        $items = $data->slice(($currentPage - 1) * $perPage, $perPage)->values(); // Slice data for the current page

        return new LengthAwarePaginator(
            $items,
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
