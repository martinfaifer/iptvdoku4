<?php

namespace App\Livewire\Settings\Geniustv\ChannelsTaxes;

use App\Livewire\Forms\CreateSettingsGeniusTvChannelsTaxesForm;
use App\Livewire\Forms\UpdateSettingsGeniusTvChannelsTaxesForm;
use App\Models\Channel;
use App\Models\Currency;
use App\Models\GeniusTVchannelsTax;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsGeniusTvChannelsTaxesComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsGeniusTvChannelsTaxesForm $form;

    public UpdateSettingsGeniusTvChannelsTaxesForm $updateForm;

    public $query = '';

    public bool $createModal = false;

    public bool $updateModal = false;

    public Collection $currencies;

    public Collection $channels;

    public function mount()
    {
        $this->channels = Channel::get(['id', 'name']);
        $this->currencies = Currency::get();
    }

    public function openCreateModal()
    {
        $this->resetErrorBag();

        return $this->createModal = true;
    }

    public function closeDialog()
    {
        $this->updateModal = false;

        return $this->createModal = false;
    }

    public function create()
    {
        $this->form->create();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_channels_taxes');

        $this->success_alert('Vytvořeno');
    }

    public function edit(GeniusTVchannelsTax $channelTax)
    {
        $this->resetErrorBag();

        $this->updateForm->setChannelTax($channelTax);

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_channels_taxes');

        return $this->success_alert('Upraveno');
    }

    public function destroy(GeniusTVchannelsTax $channelTax)
    {
        $channelTax->delete();

        $this->dispatch('refresh_settings_genius_tv_channels_taxes');
    }

    #[On('refresh_settings_genius_tv_channels_taxes')]
    public function render()
    {
        return view('livewire.settings.geniustv.channels-taxes.settings-genius-tv-channels-taxes-component', [
            'channelsTaxes' => GeniusTVchannelsTax::with('currency_name', 'channel')
                ->search($this->query)
                ->paginate(5),
            'headers' => [
                ['key' => 'channel.name', 'label' => 'Kanál', 'class' => 'text-white/80'],
                ['key' => 'price', 'label' => 'Cena', 'class' => 'text-white/80'],
                ['key' => 'currency_name.name', 'label' => 'Měna', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
