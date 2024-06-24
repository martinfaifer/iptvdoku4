<?php

namespace App\Livewire\Settings\Geniustv\OfferTaxes;

use App\Models\Channel;
use Livewire\Component;
use App\Models\Currency;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Models\GeniusTVChannelsOffersTax;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateSettingsGeniusTvOfferTaxesForm;
use App\Livewire\Forms\UpdateSettingsGeniusTvOfferTaxesForm;

class SettingsGeniusTvOfferTaxesComponent extends Component
{
    use NotificationTrait, WithPagination;

    public string $query = '';

    public CreateSettingsGeniusTvOfferTaxesForm $form;

    public UpdateSettingsGeniusTvOfferTaxesForm $updateForm;

    public bool $createModal = false;

    public bool $updateModal = false;

    public Collection $currencies;

    public Collection $channels;

    public function mount()
    {
        $this->channels = Cache::get('channels_menu');
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

        $this->dispatch('refresh_settings_genius_tv_offers_taxes');

        $this->success_alert('Vytvořeno');
    }

    public function edit(GeniusTVChannelsOffersTax $offerTax)
    {
        $this->resetErrorBag();

        $this->updateForm->setOfferTax($offerTax);

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_offers_taxes');

        return $this->success_alert('Upraveno');
    }

    public function destroy(GeniusTVChannelsOffersTax $offerTax)
    {
        $offerTax->delete();

        $this->dispatch('refresh_settings_genius_tv_offers_taxes');
    }

    #[On('refresh_settings_genius_tv_offers_taxes')]
    public function render()
    {
        return view('livewire.settings.geniustv.offer-taxes.settings-genius-tv-offer-taxes-component', [
            'offerTaxes' => GeniusTVChannelsOffersTax::with('currency_name')
                ->search($this->query)
                ->paginate(5),
            'headers' => [
                ['key' => 'offer', 'label' => 'Offer', 'class' => 'text-white/80'],
                ['key' => 'channels_id', 'label' => 'Kanály', 'class' => 'text-white/80'],
                ['key' => 'price', 'label' => 'Cena', 'class' => 'text-white/80'],
                ['key' => 'currency_name.name', 'label' => 'Měna', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
