<?php

namespace App\Livewire\Settings\Channels\Restart;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RestartChannel;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateSettingsChannelsRestartForm;

class SettingsChannelsRestartComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsChannelsRestartForm $createForm;

    public bool $createModal = false;

    public function mount(): void
    {
        //
    }

    public function openCreateModal(): void
    {
        $this->createModal = true;
    }

    public function closeDialog(): void
    {
        $this->resetErrorBag();
        $this->createForm->reset();

        $this->createModal = false;
    }

    public function create(): mixed
    {
        $this->createForm->create();

        $this->closeDialog();

        return $this->success_alert('vytvořeno');
    }

    public function destroy(RestartChannel $restartChannel): mixed
    {
        $restartChannel->delete();

        return $this->success_alert('Odebráno');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
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
