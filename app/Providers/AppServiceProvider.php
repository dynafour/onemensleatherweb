<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema; // Tambahkan ini
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        require_once app_path('Helpers/globals.php');

        // Cek apakah tabel 'settings' sudah ada sebelum mengaksesnya
        if (Schema::hasTable('settings')) {
            // Ambil data setting dari tabel settings where id_setting = 1
            $settings = Setting::where('id_setting', 1)->first();
            
            // Share variable $setting ke semua view
            View::share('setting', $settings);

            // Simpan setting di container aplikasi
            $this->app->singleton('setting', function () use ($settings) {
                return $settings;
            });
        }
    }
}