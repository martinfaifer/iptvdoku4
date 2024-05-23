<?php

use App\Livewire\Wiki\WikiComponent;
use App\Models\User;
use App\Models\UserRole;
use App\Models\WikiTopic;

it('return wiki route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('wiki')->assertSeeLivewire(WikiComponent::class);
});

it('return wiki topic route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $topic = WikiTopic::first();
    if (is_null($topic)) {
        $this->actingAs($user)->get('wiki/null')->assertStatus(404);
    } else {
        $this->actingAs($user)->get('wiki/' . $topic->id)->assertSeeLivewire(WikiComponent::class);
    }
});
