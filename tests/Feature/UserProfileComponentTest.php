<?php

use App\Livewire\User\UserActionsComponent;
use App\Livewire\User\UserComponent;
use App\Livewire\User\UserNotificationComponent;
use App\Models\User;
use App\Models\UserRole;

it('return user profile route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('profile')->assertSeeLivewire(UserComponent::class);
});

it('return user profile notifications route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('profile/notifications')->assertSeeLivewire(UserNotificationComponent::class);
});

it('return user profile actions route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('profile/actions')->assertSeeLivewire(UserActionsComponent::class);
});
