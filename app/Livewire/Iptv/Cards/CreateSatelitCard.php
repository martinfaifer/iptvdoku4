<?php

namespace App\Livewire\Iptv\Cards;

use App\Livewire\Forms\StoreSatelitCardForm;
use App\Models\SatelitCardVendor;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CreateSatelitCard extends Component
{
    use NotificationTrait;

    public StoreSatelitCardForm $storeForm;

    public Collection $satelitCardsVendors;

    public bool $storeModal = false;

    public function mount(): void
    {
        $this->satelitCardsVendors = SatelitCardVendor::get();
    }

    public function create(): mixed
    {
        $satCard = $this->storeForm->create();

        $this->dispatch('update_satelit_cards_menu');

        $this->closeDialog();

        $this->redirect('/sat-cards/'.$satCard->id, true);

        return $this->success_alert('Vytvořeno');
    }

    public function openModal(): void
    {
        $this->storeModal = true;
    }

    public function closeDialog(): void
    {
        $this->resetErrorBag();

        $this->storeModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.cards.create-satelit-card');
    }
}
