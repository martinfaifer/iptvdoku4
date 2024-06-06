<?php

use App\Livewire\Iptv\Channels\IptvChannel;
use App\Models\Channel;
use App\Models\User;
use App\Models\UserRole;

it('return channels index as channel route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('channels')->assertSeeLivewire(IptvChannel::class);
});

it('return channel multicast', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $channel = Channel::first();
    $this->actingAs($user)->get('channels/'.$channel->id.'/multicast')->assertSeeLivewire(IptvChannel::class);
});

it('return channel h264', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $channel = Channel::first();
    $this->actingAs($user)->get('channels/'.$channel->id.'/h264')->assertSeeLivewire(IptvChannel::class);
});

it('return channel h265', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $channel = Channel::first();
    $this->actingAs($user)->get('channels/'.$channel->id.'/h265')->assertSeeLivewire(IptvChannel::class);
});
