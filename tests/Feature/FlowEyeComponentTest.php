<?php

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Cache;
use App\Livewire\Iptv\FlowEye\FlowEyeComponent;

it('return floweyes route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('floweye')->assertSeeLivewire(FlowEyeComponent::class);
});

it('return wiki topic route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();

    if (!Cache::has('floweye_active_tickets')) {
        $this->actingAs($user)->get('floweye/null')->assertStatus(200);
    } else {
        $tickets = Cache::get('floweye_active_tickets');
        foreach ($tickets['data'] as $ticket) {
            $this->actingAs($user)->get('floweye/' . $ticket['id'])->assertSeeLivewire(FlowEyeComponent::class);
        }
    }
});
