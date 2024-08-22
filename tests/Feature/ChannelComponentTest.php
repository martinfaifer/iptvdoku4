<?php

use App\Models\User;
use Livewire\Livewire;
use App\Models\Channel;
use App\Models\UserRole;
use Illuminate\Support\Str;
use App\Livewire\Iptv\Channels\IptvChannel;
use App\Livewire\Iptv\Channels\StoreChannel;
use App\Livewire\Iptv\Channels\UpdateChannel;

it('return channels index as channel route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('channels')->assertSeeLivewire(IptvChannel::class);
});

it('create new channel', function () {
    if ($channel = Channel::where('name', 'Test Channel')->first()) {
        $channel->delete();
    }
    Livewire::test(StoreChannel::class)
        ->set('name', 'Test Channel')
        ->set('is_radio', false)
        ->set('is_multiscreen', true)
        ->set('quality', 1)
        ->set('category', 1)
        ->set('description', 'Test Description')
        ->set('nangu_chunk_store_id', 'test_chunk_store_id')
        ->set('nangu_channel_code', 'test_channel_code')
        ->call('store')
        ->assertRedirect('/channels/' . Channel::where('name', 'Test Channel')->first()->id . '/multicast');
});

it('update channel', function () {
    $channel = Channel::where('name', 'Test Channel')->first();
    Livewire::test(UpdateChannel::class, [
        'channel' => $channel,
        // 'form.channel' => $channel,
        'channelType' => null
    ])
        ->set('form.channel', $channel)
        ->set('form.description', 'Updated Test Description')
        ->call('update')
        ->assertRedirect('/channels/' . $channel->id . '/multicast');
});

it('return channel multicast', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $channel = Channel::first();
    $this->actingAs($user)->get('channels/' . $channel->id . '/multicast')->assertSeeLivewire(IptvChannel::class);
});

it('return channel h264', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $channel = Channel::first();
    $this->actingAs($user)->get('channels/' . $channel->id . '/h264')->assertSeeLivewire(IptvChannel::class);
});

it('return channel h265', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $channel = Channel::first();
    $this->actingAs($user)->get('channels/' . $channel->id . '/h265')->assertSeeLivewire(IptvChannel::class);
});
