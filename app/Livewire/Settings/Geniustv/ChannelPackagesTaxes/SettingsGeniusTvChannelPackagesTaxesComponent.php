<?php

namespace App\Livewire\Settings\Geniustv\ChannelPackagesTaxes;

use App\Livewire\Forms\CreateSettingsGeniusTvChannelPackagesTaxesForm;
use App\Livewire\Forms\UpdateSettingsGeniusTvChannelPackagesTaxesForm;
use App\Models\Channel;
use App\Models\Currency;
use App\Models\GeniusTVchannelPackagesTax;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsGeniusTvChannelPackagesTaxesComponent extends Component
{
    use NotificationTrait, WithPagination;

    public string $query = '';

    public CreateSettingsGeniusTvChannelPackagesTaxesForm $form;

    public UpdateSettingsGeniusTvChannelPackagesTaxesForm $updateForm;

    public bool $createModal = false;

    public bool $updateModal = false;

    public Collection $currencies;

    public Collection $channels;

    public function mount(): void
    {
        $this->channels = Channel::get(['id', 'name']);
        $this->currencies = Currency::get();
    }

    public function openCreateModal(): void
    {
        $this->resetErrorBag();

        $this->createModal = true;
    }

    public function closeDialog(): void
    {
        $this->updateModal = false;

        $this->createModal = false;
    }

    public function create(): mixed
    {
        $this->form->create();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_channel_packages_taxes');

        return $this->success_alert('Vytvořeno');
    }

    public function edit(GeniusTVchannelPackagesTax $channelPackageTax): void
    {
        $this->resetErrorBag();

        $this->updateForm->setChannelPackageTax($channelPackageTax);

        $this->updateModal = true;
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_channel_packages_taxes');

        return $this->success_alert('Upraveno');
    }

    public function destroy(GeniusTVchannelPackagesTax $channelPackageTax): void
    {
        $channelPackageTax->delete();

        $this->dispatch('refresh_settings_genius_tv_channel_packages_taxes');
    }

    #[On('refresh_settings_genius_tv_channel_packages_taxes')]
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.geniustv.channel-packages-taxes.settings-genius-tv-channel-packages-taxes-component', [
            'channelPackagesTaxes' => GeniusTVchannelPackagesTax::with('currency_name')
                ->search($this->query)
                ->paginate(5),
            'headers' => [
                ['key' => 'channels_id', 'label' => 'Kanály', 'class' => 'dark:text-white/80'],
                ['key' => 'exception', 'label' => 'Výjimky', 'class' => 'dark:text-white/80'],
                ['key' => 'price', 'label' => 'Cena', 'class' => 'dark:text-white/80'],
                ['key' => 'currency_name.name', 'label' => 'Měna', 'class' => 'dark:text-white/80'],
                ['key' => 'must_contains_all', 'label' => 'Musí být všechny kanály', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
