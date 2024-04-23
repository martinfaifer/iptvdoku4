<?php

namespace App\Providers;

use Laravel\Fortify\Fortify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

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
        // Model::shouldBeStrict();
        JsonResource::withoutWrapping();
        // Fortify::loginView(function() {
        //     return view('livewire.auth.login');
        // });
    }
}
