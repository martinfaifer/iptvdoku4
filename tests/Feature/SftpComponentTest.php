<?php

use App\Models\User;
use App\Models\UserRole;
use App\Livewire\Iptv\Sftps\SftpComponent;
use App\Models\SftpServer;

it('return sftps route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('sftps')->assertSeeLivewire(SftpComponent::class);
});

it('return sftp route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $sftp = SftpServer::first();
    if (is_null($sftp)) {
        $this->actingAs($user)->get('sftps/null')->assertStatus(404);
    }
    $this->actingAs($user)->get('sftps/' . $sftp->id)->assertSeeLivewire(SftpComponent::class);
});
