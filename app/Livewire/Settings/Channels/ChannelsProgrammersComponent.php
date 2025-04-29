<?php

namespace App\Livewire\Settings\Channels;

use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ChannelProgramer;
use App\Models\ChannelProgramerContanct;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Channels\ChannelProgramerTrait;
use App\Livewire\Forms\CreateChannelProgrammerForm;

class ChannelsProgrammersComponent extends Component
{
    use WithPagination, NotificationTrait, ChannelProgramerTrait;

    public CreateChannelProgrammerForm $createForm;

    public string $query = '';
    public bool $createModal = false;
    public bool $editModal = false;

    public function openCreateModal(): void
    {
        $this->createModal = true;
    }

    public function closeDialog()
    {
        $this->resetErrorBag();
        $this->createModal = false;
        $this->editModal = false;
    }

    public function create(): void
    {
        $this->createForm->create();

        $this->dispatch('reload_settings_programmers');

        $this->resetErrorBag();

        $this->closeDialog();

        $this->success_alert('Přidáno');
    }

    public function edit(ChannelProgramer $programmer): void
    {
        $this->editModal = true;
    }

    public function destroy(ChannelProgramer $programer): void
    {
        // get all channels belongs to programmer and change channel_programmer_id to null
        $channels = Channel::where('channel_programmer_id', $programer->id)->get();
        if (!$channels->isEmpty()) {
            foreach ($channels as $channel) {
                $channel->update([
                    'channel_programmer_id' => null
                ]);
            }
        }

        ChannelProgramerContanct::where('channel_programmer_id', $programer->id)->delete();
        $programer->delete();
        $this->removeCachedChannelProgramers();
        $this->dispatch('reload_settings_programmers');
        $this->success_alert('Odebráno');
    }

    #[On('reload_settings_programmers')]
    public function render()
    {
        return view('livewire.settings.channels.channels-programmers-component', [
            'programers' => ChannelProgramer::with('contacts')->search($this->query)->paginate(10),
            'headers' => [
                ['key' => 'name', 'label' => 'Název', 'class' => 'text-white/80'],
                ['key' => 'contacts.name', 'label' => 'Kontaktní osoba', 'class' => 'text-white/80'],
                ['key' => 'contacts.email', 'label' => 'Kontaktní email', 'class' => 'text-white/80'],
                ['key' => 'contacts.phone', 'label' => 'Kontaktní telefon', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
