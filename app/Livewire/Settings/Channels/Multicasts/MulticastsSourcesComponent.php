<?php

namespace App\Livewire\Settings\Channels\Multicasts;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ChannelSource;
use App\Livewire\Forms\CreateMulticastSourceForm;
use App\Traits\Livewire\NotificationTrait;

class MulticastsSourcesComponent extends Component
{
    use WithPagination, NotificationTrait;

    public CreateMulticastSourceForm $createForm;

    public string $query = "";

    public bool $createModal = false;

    public function openCreateModal()
    {
        return $this->createModal = true;
    }

    public function create()
    {
        $this->createForm->create();

        $this->dispatch('reload_settings_multicasts_sources');

        $this->resetErrorBag();

        $this->closeDialog();

        return $this->success_alert("Přidáno");
    }

    public function closeDialog()
    {
        return $this->createModal = false;
    }

    public function destroy(ChannelSource $channelSource)
    {
        if ($channelSource->multicasts->isEmpty() == false) {
            return $this->error_alert("Existuje vazba na kanál");
        }

        $channelSource->delete();

        $this->dispatch('reload_settings_multicasts_sources');

        return $this->success_alert("Odebráno");
    }


    #[On('reload_settings_multicasts_sources')]
    public function render()
    {
        return view('livewire.settings.channels.multicasts.multicasts-sources-component', [
            'sources' => ChannelSource::search($this->query)->paginate(10),
            'headers' => [
                ['key' => 'name', 'label' => 'Zdroj', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
