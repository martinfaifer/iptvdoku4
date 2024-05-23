<?php

use App\Models\User;
use App\Models\UserRole;
use App\Livewire\Iptv\Calendar\CalendarComponent;

it('return calendar route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('calendar')->assertSeeLivewire(CalendarComponent::class);
});
