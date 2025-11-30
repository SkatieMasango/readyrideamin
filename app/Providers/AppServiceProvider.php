<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       if(!$this->app->runningInConsole()){
            if (!file_exists(base_path('storage/installed')) && !request()->is('install') && !request()->is('install/*')) {
                header("Location: install");
                exit;
            }
        }
    }
}
