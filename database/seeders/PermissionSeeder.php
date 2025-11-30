<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{

    public function run()
    {
         Permission::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        $users = User::whereHas('roles', function($role){
            $role->where('name', 'admin');
        })->get();

         foreach($users as $user){
            $roleId = $user->roles->first();

            $roleId->givePermissionTo('admin');
        }

        $permissions = config('acl.permissions');

        if (empty($permissions) || !is_array($permissions)) {
            return;
        }

        foreach ($permissions as $permission => $value) {
            Permission::findOrCreate($permission, 'web');
        }
    }
}
