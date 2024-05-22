<?php

namespace App\Providers;

use App\Models\H264;
use App\Models\User;
use App\Models\Event;
use App\Models\Device;
use App\Models\Channel;
use App\Models\WikiTopic;
use App\Models\SftpServer;
use App\Models\SatelitCard;
use App\Models\WikiCategory;
use App\Policies\H264Policy;
use App\Policies\SftpPolicy;
use App\Policies\UserPolicy;
use Laravel\Fortify\Fortify;
use App\Policies\EventPolicy;
use App\Policies\DevicePolicy;
use App\Policies\ChannelPolicy;
use App\Models\ChannelMulticast;
use Laravel\Pulse\Facades\Pulse;
use App\Policies\MulticastPolicy;
use App\Policies\WikiTopicPolicy;
use App\Policies\SatelitCardPolicy;
use App\Policies\WikiCategoryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;
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
        Pulse::user(fn ($user) => [
            'name' => $user->email,
            'extra' => "user role " . $user->userRole->name,
            'avatar' => $user->avatar_url,
        ]);

        // Model::shouldBeStrict();
        JsonResource::withoutWrapping();
        Gate::define('viewPulse', function (User $user) {
            return $user->isAdmin();
        });

        LogViewer::auth(function (User $user) {
            return $user->isAdmin();
        });

        Gate::policy(SftpServer::class, SftpPolicy::class);
        Gate::policy(Device::class, DevicePolicy::class);
        Gate::policy(Event::class, EventPolicy::class);
        Gate::policy(H264::class, H264Policy::class);
        Gate::policy(Channel::class, ChannelPolicy::class);
        Gate::policy(ChannelMulticast::class, MulticastPolicy::class);
        Gate::policy(SatelitCard::class, SatelitCardPolicy::class);
        Gate::policy(WikiTopic::class, WikiTopicPolicy::class);
        Gate::policy(WikiCategory::class, WikiCategoryPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
