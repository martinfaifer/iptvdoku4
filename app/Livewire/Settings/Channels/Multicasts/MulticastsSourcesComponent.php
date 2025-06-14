<?php

namespace App\Livewire\Settings\Channels\Multicasts;

use App\Livewire\Forms\CreateMulticastSourceForm;
use App\Models\ChannelSource;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MulticastsSourcesComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateMulticastSourceForm $createForm;

    public string $query = '';

    public bool $createModal = false;

    public function openCreateModal(): void
    {
        $this->createModal = true;
    }

    public function create(): mixed
    {
        $this->createForm->create();

        $this->dispatch('reload_settings_multicasts_sources');

        $this->resetErrorBag();

        $this->closeDialog();

        return $this->success_alert('Přidáno');
    }

    public function closeDialog(): void
    {
        $this->createModal = false;
    }

    public function destroy(ChannelSource $channelSource): mixed
    {
        if ($channelSource->multicasts->isEmpty() == false) {
            return $this->error_alert('Existuje vazba na kanál');
        }

        $channelSource->delete();

        $this->dispatch('reload_settings_multicasts_sources');

        return $this->success_alert('Odebráno');
    }

    #[On('reload_settings_multicasts_sources')]
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.channels.multicasts.multicasts-sources-component', [
            'sources' => ChannelSource::search($this->query)->paginate(10),
            'headers' => [
                ['key' => 'name', 'label' => 'Zdroj', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
