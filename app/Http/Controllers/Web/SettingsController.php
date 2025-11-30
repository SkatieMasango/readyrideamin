<?php

namespace App\Http\Controllers\Web;

use App\Models\Settings;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\GeneralSettingsRequest;

class SettingsController extends Controller
{
    public function index(): View
    {
        $setting = Settings::query()->where('key', 'site_config')->value('value');

        $generalSettings = $setting ? json_decode($setting) : [];

        return view('settings.index', compact('generalSettings'));
    }

    public function store(GeneralSettingsRequest $request): RedirectResponse
    {
        $setting = Settings::query()->where('key', 'site_config')->first();

        if (! $setting) {
            return back()->withErrors(['error' => 'Site configuration not found.']);
        }

        $existingValue = json_decode($setting->value, true) ?? [];

        $data = $request->only([
            'site_name', 'site_title', 'currency', 'currency_position',
            'site_phone', 'site_email', 'site_address',
            'android_app_link', 'ios_app_link','commision'
        ]);

        collect(['website_logo', 'site_favicon', 'site_app_logo'])->each(function ($key) use ($request, &$data, $existingValue) {
            $data[$key] = $request->hasFile($key)
                ? $request->file($key)->store($key, 'public')
                : ($existingValue[$key] ?? '');
        });


        $setting->update(['value' => json_encode($data)]);

        return redirect()->route('management.settings.index')->with('success', 'Settings updated successfully.');
    }
}
