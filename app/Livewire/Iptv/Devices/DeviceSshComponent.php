<?php

namespace App\Livewire\Iptv\Devices;

use App\Models\Device;
use App\Models\DeviceSsh;
use App\Models\Tag;
use App\Models\TagOnItem;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

// #[On('echo:check_if_need_ssh.{device.id},BroadcastCheckIfDeviceNeedSshEvent')]
class DeviceSshComponent extends Component
{
    use NotificationTrait;

    public Device $device;

    public bool $has_ssh_credentials = false;

    public bool $storeModal = false;

    public bool $updateModal = false;

    public mixed $deviceSsh;

    #[Validate('required', message: 'Vyplňte uživatelské jméno')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:100', message: 'Maximální počet znaků je :max')]
    public string $username = '';

    #[Validate('required', message: 'Vyplňte heslo jméno')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:100', message: 'Maximální počet znaků je :max')]
    public string $password = '';

    public function mount(Device $device): void
    {
        try {
            $this->device = $device;
            $this->deviceSsh = $device->ssh;
            $this->checkIfNeedSsh();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    #[On('check_if_need_ssh.{device.id}')]
    public function checkIfNeedSsh(): void
    {
        // check if device has tag if need ssh
        // tag action check_gpu id 1
        // tag action ssh_login id 4
        $tags = Tag::where('action', 1)->orwhere('action', 4)->get();
        foreach ($tags as $tag) {
            if (TagOnItem::where('type', 'device')
                ->where('item_id', $this->device->id)
                ->where('tag_id', $tag->id)->first()
            ) {
                if (is_null($this->deviceSsh)) {
                    $this->storeModal = true;
                }
            }
        }
    }

    public function store(): mixed
    {
        $this->validate();

        DeviceSsh::create([
            'device_id' => $this->device->id,
            'username' => $this->username,
            'password' => $this->password,
        ]);

        $this->closeDialog();

        $this->dispatch('refresh_device_ssh');

        return $this->success_alert('Přidáno');
    }

    public function openUpdateModal(): void
    {
        $this->username = $this->deviceSsh->username;
        $this->password = $this->deviceSsh->password;

        $this->updateModal = true;
    }

    public function update(): mixed
    {
        $this->validate();

        $this->deviceSsh->update([
            'username' => $this->username,
            'password' => $this->password,
        ]);

        $this->closeDialog();

        $this->dispatch('refresh_device_ssh');

        return $this->success_alert('Upraveno');
    }

    public function closeDialog(): void
    {
        $this->reset('username', 'password');
        $this->storeModal = false;
        $this->updateModal = false;

        $this->resetErrorBag();
    }

    public function destroy(): mixed
    {
        $this->deviceSsh->delete();

        $this->dispatch('refresh_device_ssh');

        return $this->success_alert('Odebráno');
    }

    #[On('echo:refresh_device_ssh.{device.id},BroadcastCheckIfDeviceNeedSshEvent')]
    #[On('refresh_device_ssh')]
    public function refreshDeviceSsh(): void
    {
        $this->deviceSsh = DeviceSsh::where('device_id', $this->device->id)->first();
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.devices.device-ssh-component');
    }
}
