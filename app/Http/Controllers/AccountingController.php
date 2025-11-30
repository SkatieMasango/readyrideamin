<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function admin($name, Request $request): View
    {
        $setting = Settings::query()->where('key', 'site_config')->value('value');
        $generalSettings = $setting ? json_decode($setting) : [];

        $search   = $request->input('search');
        $perPage = $request->query('per_page', 10);

        // if($name === 'fleets'){
        //     $data = Wallet::whereHas('user.roles', function ($q) {
        //     $q->where('name', 'fleet');
        //     })->with('user')->paginate($perPage);

        // }else
        if($name === 'drivers'){
           $data = Wallet::whereHas('user.roles', function ($q) {
            $q->where('name', 'driver');
            })->with('user')->paginate($perPage);
        }
        elseif($name === 'riders'){
           $data = Wallet::whereHas('user.roles', function ($q) {
            $q->where('name', 'rider');
            })->with('user')->paginate($perPage);
        }elseif($name === 'admin'){
            $data = Transaction::where('transaction', 'credit')->paginate($perPage);
            return view('accounting.admin', compact('data'));
        }

        return view('accounting.index', compact('data','generalSettings'));
    }

}
