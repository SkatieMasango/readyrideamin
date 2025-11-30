<?php
namespace App\Repositories;

use App\Models\User;
use App\Enums\Status;
use Abedin\Maker\Repositories\Repository;


class UserRepository extends Repository
{
    public static function model()
    {
        return User::class;
    }

    public static function findOrStoreByMobile($mobile, $request)
    {
        $user = self::query()->withTrashed()->where('mobile', $mobile)->first();

        if (!$user) {
            $user = User::create([
                'mobile' => $mobile,
                'country_iso' => $request->country_iso,
            ]);


            WalletRepository::create(['user_id' => $user->id, 'amount' => 0]);
        }else{
              $user->update([
            'deleted_at' => null
        ]);
        }

        self::checkUserRole($user, $request->role);

        return $user;

    }

    public static function updateByRequest($request, $user): void
    {
        self::update($user, [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'gender' => $request->gender,
        ]);
     }

    /**
     * Checks if the user has the given role, if not creates one.
     *
     * @param User $user
     * @param string $role
     * @return void
     */
    private static function checkUserRole($user ,$role): void
    {
        $driver = $user->driver;
        $rider = $user->rider;

        if ($role === 'driver' && !$driver) {
            DriverRepository::create(['user_id' => $user->id]);
            $user->update(['status' => Status::PENDING_APPROVAL]);
            $user->assignRole('driver');
        } elseif ($role === 'rider' && !$rider) {
            RiderRepository::create(['user_id' => $user->id]);
            $user->update(['status' => Status::APPROVED]);
            $user->assignRole('rider');
        }
    }

    public static function getRole($role){
         return self::query()->role($role)->first();
    }
}
