<?php

namespace App\Providers;

use App\Models\Admin\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('site_settings')) {
            $timezone = SiteSetting::get('site_timezone', config('app.timezone'));

            config(['app.timezone' => $timezone]);
            date_default_timezone_set($timezone);
        }
    }
}
