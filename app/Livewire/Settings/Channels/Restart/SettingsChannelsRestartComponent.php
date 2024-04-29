<?php

namespace App\Livewire\Settings\Channels\Restart;

use App\Livewire\Forms\CreateSettingsChannelsRestartForm;
use App\Models\RestartChannel;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsChannelsRestartComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsChannelsRestartForm $createForm;

    public bool $createModal = false;

    public function mount()
    {
        //
    }

    public function openCreateModal()
    {
        return $this->createModal = true;
    }

    public function closeDialog()
    {
        $this->resetErrorBag();
        $this->createForm->reset();

        return $this->createModal = false;
    }

    public function create()
    {
        $this->createForm->create();

        $this->closeDialog();

        return $this->success_alert('vytvořeno');
    }

    public function destroy(RestartChannel $restartChannel)
    {
        $restartChannel->delete();

        return $this->success_alert('Odebráno');
    }

    public function render()
    {
        return view('livewire.settings.channels.restart.settings-channels-restart-component', [
            'channelsFroRestart' => RestartChannel::with(['channel', 'device', 'stream_ip'])->paginate(5),
            'headers' => [
                ['key' => 'channel.name', 'label' => 'Kanál', 'class' => 'text-white/80'],
                ['key' => 'stream_ip.ip', 'label' => 'Url streamu', 'class' => 'text-white/80'],
                ['key' => 'device.name', 'label' => 'Vazba na zařízení', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
