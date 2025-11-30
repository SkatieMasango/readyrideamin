<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run()
    // {
    //     // Create permissions
    //     Permission::create(['name' => 'vehicles.view']);
    //     Permission::create(['name' => 'vehicles.edit']);

    //     // Create role and assign permissions
    //     $adminRole = Role::create(['name' => 'admin']);
    //     $adminRole->givePermissionTo(['vehicles.view', 'vehicles.edit']);

    //     // Assign role to user
    //     $user = User::find(1); // Make sure user with ID 1 exists
    //     if ($user) {
    //         $user->assignRole('admin');
    //     }
    // }

    public function run()
    {
        $this->grantPermissionsToRoles();
    }

      private function grantPermissionsToRoles()
    {
        foreach (config('acl.roles') as $key => $roleName) {
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                $permissions = [];

                foreach (config('acl.permissions') as $permission => $roles) {
                    if (in_array($roleName, $roles)) {
                        $permissions[] = $permission;
                    }
                }
                $role->syncPermissions($permissions);

                $users = User::role($roleName)->get() ?? [];
                foreach($users as $user){
                    $user->syncPermissions($permissions);
                }
            }
        }
    }
}
