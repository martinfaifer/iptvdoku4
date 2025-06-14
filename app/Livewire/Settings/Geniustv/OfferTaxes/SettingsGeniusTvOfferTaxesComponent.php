<?php

namespace App\Livewire\Settings\Geniustv\OfferTaxes;

use App\Livewire\Forms\CreateSettingsGeniusTvOfferTaxesForm;
use App\Livewire\Forms\UpdateSettingsGeniusTvOfferTaxesForm;
use App\Models\Currency;
use App\Models\GeniusTVChannelsOffersTax;
use App\Traits\Channels\GetChannelFromCacheTrait;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsGeniusTvOfferTaxesComponent extends Component
{
    use GetChannelFromCacheTrait, NotificationTrait, WithPagination;

    public string $query = '';

    public CreateSettingsGeniusTvOfferTaxesForm $form;

    public UpdateSettingsGeniusTvOfferTaxesForm $updateForm;

    public bool $createModal = false;

    public bool $updateModal = false;

    public Collection $currencies;

    public Collection $channels;

    public function mount(): void
    {
        $this->channels = $this->get_channels_from_cache();
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

        $this->dispatch('refresh_settings_genius_tv_offers_taxes');

        return $this->success_alert('Vytvořeno');
    }

    public function edit(GeniusTVChannelsOffersTax $offerTax): void
    {
        $this->resetErrorBag();

        $this->updateForm->setOfferTax($offerTax);

        $this->updateModal = true;
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_offers_taxes');

        return $this->success_alert('Upraveno');
    }

    public function destroy(GeniusTVChannelsOffersTax $offerTax): void
    {
        $offerTax->delete();

        $this->dispatch('refresh_settings_genius_tv_offers_taxes');
    }

    #[On('refresh_settings_genius_tv_offers_taxes')]
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.geniustv.offer-taxes.settings-genius-tv-offer-taxes-component', [
            'offerTaxes' => GeniusTVChannelsOffersTax::with('currency_name')
                ->search($this->query)
                ->paginate(5),
            'headers' => [
                ['key' => 'offer', 'label' => 'Offer', 'class' => 'dark:text-white/80'],
                ['key' => 'channels_id', 'label' => 'Kanály', 'class' => 'dark:text-white/80'],
                ['key' => 'price', 'label' => 'Cena', 'class' => 'dark:text-white/80'],
                ['key' => 'currency_name.name', 'label' => 'Měna', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
