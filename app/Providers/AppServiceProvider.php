<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('viewPulse', function (User $user) {
            return in_array($user->email, [
                'martinfaifer@gmail.com', 'faifer@grapesc.cz',
            ]);
        });
        // Fortify::loginView(function() {
        //     return view('livewire.auth.login');
        // });
    }
}
