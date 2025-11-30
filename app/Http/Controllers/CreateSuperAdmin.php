<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;

class CreateSuperAdmin extends Controller
{
    public function index()
    {
        return view('create-root');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Admin User
        $localAdmin = UserRepository::create([
                'email' => $request->email,
                'mobile' => '011' . rand(100000000, 999999999),
                'name' => 'Administrator',
                'email_verified_at' => now(),
                'password' => bcrypt($request->password),
            ]);


        $localAdmin->assignRole('root');

        WalletRepository::create([
            'user_id' => $localAdmin->id,
            'amount' => 0
        ]);

        // Redirect to the dashboard or any other page
        return redirect()->route('dashboard')->with('success', 'You are ready to use ReadyRide! Please login with your credentials.');
    }
}
