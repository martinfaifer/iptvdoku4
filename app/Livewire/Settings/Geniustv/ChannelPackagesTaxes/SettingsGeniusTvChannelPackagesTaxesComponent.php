<?php

namespace App\Livewire\Settings\Geniustv\ChannelPackagesTaxes;

use App\Models\Channel;
use Livewire\Component;
use App\Models\Currency;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use App\Models\GeniusTvChannelPackage;
use App\Models\GeniusTVchannelPackagesTax;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateSettingsGeniusTvChannelPackagesTaxesForm;
use App\Livewire\Forms\UpdateSettingsGeniusTvChannelPackagesTaxesForm;

class SettingsGeniusTvChannelPackagesTaxesComponent extends Component
{
    use NotificationTrait, WithPagination;

    public string $query = "";

    public CreateSettingsGeniusTvChannelPackagesTaxesForm $form;

    public UpdateSettingsGeniusTvChannelPackagesTaxesForm $updateForm;

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

        $this->dispatch('refresh_settings_genius_tv_channel_packages_taxes');

        $this->success_alert("Vytvořeno");
    }

    public function edit(GeniusTVchannelPackagesTax $channelPackageTax)
    {
        $this->resetErrorBag();

        $this->updateForm->setChannelPackageTax($channelPackageTax);

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_channel_packages_taxes');

        return $this->success_alert("Upraveno");
    }

    public function destroy(GeniusTVchannelPackagesTax $channelPackageTax)
    {
        $channelPackageTax->delete();

        $this->dispatch('refresh_settings_genius_tv_channel_packages_taxes');
    }

    #[On('refresh_settings_genius_tv_channel_packages_taxes')]
    public function render()
    {
        return view('livewire.settings.geniustv.channel-packages-taxes.settings-genius-tv-channel-packages-taxes-component', [
            'channelPackagesTaxes' => GeniusTVchannelPackagesTax
                ::with('currency_name')
                ->search($this->query)
                ->paginate(5),
            'headers' => [
                ['key' => 'channels_id', 'label' => 'Kanály', 'class' => 'text-white/80'],
                ['key' => 'exception', 'label' => 'Výjimky', 'class' => 'text-white/80'],
                ['key' => 'price', 'label' => 'Cena', 'class' => 'text-white/80'],
                ['key' => 'currency_name.name', 'label' => 'Měna', 'class' => 'text-white/80'],
                ['key' => 'must_contains_all', 'label' => 'Musí být všechny kanály', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
