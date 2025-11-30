<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Wallet;

class WalletRepository extends Repository
{
    public static function model()
    {
        return Wallet::class;
    }
    public static function findDriverWallet($id){
        return self::query()->where('user_id', $id)->first();
    }
    public static function getCommission($id){
        return self::query()->where('user_id',$id)->first();
    }
}
