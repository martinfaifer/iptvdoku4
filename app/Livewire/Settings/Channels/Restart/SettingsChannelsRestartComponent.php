<?php

namespace App\Livewire\Settings\Channels\Restart;

use App\Livewire\Forms\CreateSettingsChannelsRestartForm;
use App\Models\RestartChannel;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;
use Livewire\WithPagination;

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
                ['key' => 'channel.name', 'label' => 'Kanál', 'class' => 'dark:text-white/80'],
                ['key' => 'stream_ip.ip', 'label' => 'Url streamu', 'class' => 'dark:text-white/80'],
                ['key' => 'device.name', 'label' => 'Vazba na zařízení', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
