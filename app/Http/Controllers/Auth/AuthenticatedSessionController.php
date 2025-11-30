<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Settings;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $setting = Settings::query()->where('key', 'site_config')->value('value');
        $generalSettings = $setting ? json_decode($setting) : [];

        return view('auth.login', compact('generalSettings'));
    }

    /**
     * Handle an incoming authentication request.
     */


    public function store(LoginRequest $request): RedirectResponse
    {
        // $request->authenticate();

        // $request->session()->regenerate();
        $user = UserRepository::query()->where('email', $request->email)->first();

        if($user && $user->getRoleNames()[0] == 'root'){
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user, $request->filled('remember'));
                return redirect()->intended(route('dashboard', absolute: false));
            }
        }
        return back()->withErrors(['email' => 'Your account is inactive. Please contact support.'])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
