<?php

use App\Models\User;
use App\Models\Device;
use App\Models\UserRole;
use App\Livewire\Iptv\Devices\DeviceComponent;
use App\Models\DeviceCategory;

it('returns devices index as device route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $this->actingAs($user)->get('devices')->assertSeeLivewire(DeviceComponent::class);
});

it('returns multiplexor device route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $device = Device::where('device_category_id', DeviceCategory::where('name', "Multiplexor")->first()->id)->first();
    if (is_null($device)) {
        $this->actingAs($user)->get('devices/null')->assertStatus(404);
    } else {
        $this->actingAs($user)->get('devices/' . $device->id)->assertSeeLivewire(DeviceComponent::class);
    }
});


it('returns sat reciever device route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $device = Device::where('device_category_id', DeviceCategory::where('name', "Satelitní přijímač")->first()->id)->first();
    if (is_null($device)) {
        $this->actingAs($user)->get('devices/null')->assertStatus(404);
    } else {
        $this->actingAs($user)->get('devices/' . $device->id)->assertSeeLivewire(DeviceComponent::class);
    }
});


it('returns transcoder device route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $device = Device::where('device_category_id', DeviceCategory::where('name', "Transcoder")->first()->id)->first();
    if (is_null($device)) {
        $this->actingAs($user)->get('devices/null')->assertStatus(404);
    } else {
        $this->actingAs($user)->get('devices/' . $device->id)->assertSeeLivewire(DeviceComponent::class);
    }
});


it('returns ip device route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $device = Device::where('device_category_id', DeviceCategory::where('name', "Po IP")->first()->id)->first();
    if (is_null($device)) {
        $this->actingAs($user)->get('devices/null')->assertStatus(404);
    } else {
        $this->actingAs($user)->get('devices/' . $device->id)->assertSeeLivewire(DeviceComponent::class);
    }
});


it('returns Linux device route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $device = Device::where('device_category_id', DeviceCategory::where('name', "Linux")->first()->id)->first();
    if (is_null($device)) {
        $this->actingAs($user)->get('devices/null')->assertStatus(404);
    } else {
        $this->actingAs($user)->get('devices/' . $device->id)->assertSeeLivewire(DeviceComponent::class);
    }
});


it('returns satelits device route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $device = Device::where('device_category_id', DeviceCategory::where('name', "Satelity")->first()->id)->first();
    if (is_null($device)) {
        $this->actingAs($user)->get('devices/null')->assertStatus(404);
    } else {
        $this->actingAs($user)->get('devices/' . $device->id)->assertSeeLivewire(DeviceComponent::class);
    }
});

it('returns parabolas device route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $device = Device::where('device_category_id', DeviceCategory::where('name', "Paraboly")->first()->id)->first();
    if (is_null($device)) {
        $this->actingAs($user)->get('devices/null')->assertStatus(404);
    } else {
        $this->actingAs($user)->get('devices/' . $device->id)->assertSeeLivewire(DeviceComponent::class);
    }
});

it('returns multiswitches device route', function () {
    $user = User::where('user_role_id', UserRole::where('name', 'admin')->first()->id)->first();
    $device = Device::where('device_category_id', DeviceCategory::where('name', "Multiswitche")->first()->id)->first();
    if (is_null($device)) {
        $this->actingAs($user)->get('devices/null')->assertStatus(404);
    } else {
        $this->actingAs($user)->get('devices/' . $device->id)->assertSeeLivewire(DeviceComponent::class);
    }
});
