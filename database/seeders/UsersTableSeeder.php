<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(5)->create();

        // TODO for dev only
        $roles = [
            'root',
            'admin',
            'manager',
            'user',
        ];

        foreach ($roles as $role) {
            $user=User::factory()->create([
                'email' => $role.'@readyridy.com',
            ]);

            if($role == 'root'){
                // Assign role to user
                $user->assignRole($role);
                Wallet::firstOrCreate(
                        ['user_id' => $user->id],
                        ['amount' => 0]
                    );
            }
             if($role == 'admin'){
                // Assign role to user
                $user->assignRole($role);
                Wallet::firstOrCreate(
                        ['user_id' => $user->id],
                        ['amount' => 0]
                    );



            }
        }
    }
}
