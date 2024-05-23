<?php

use App\Models\User;
use App\Models\UserRole;
use App\Livewire\Iptv\Cards\SatelitCardComponent;
use App\Models\SatelitCard;

it('return sat-cards index route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('sat-cards')->assertSeeLivewire(SatelitCardComponent::class);
});

it('return sat-card route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $satCard = SatelitCard::first();
    if (is_null($satCard)) {
        $this->actingAs($user)->get('sat-cards/null')->assertStatus(404);
    } else {
        $this->actingAs($user)->get('sat-cards/' . $satCard->id)->assertSeeLivewire(SatelitCardComponent::class);
    }
});
