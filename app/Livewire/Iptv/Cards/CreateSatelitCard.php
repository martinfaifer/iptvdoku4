<?php

namespace App\Livewire\Iptv\Cards;

use App\Livewire\Forms\StoreSatelitCardForm;
use App\Models\SatelitCardVendor;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CreateSatelitCard extends Component
{
    use NotificationTrait;

    public StoreSatelitCardForm $storeForm;

    public Collection $satelitCardsVendors;

    public bool $storeModal = false;

    public function mount()
    {
        $this->satelitCardsVendors = SatelitCardVendor::get();
    }

    public function create()
    {
        $satCard = $this->storeForm->create();

        $this->dispatch('update_satelit_cards_menu');

        $this->closeDialog();

        $this->success_alert('Vytvořeno');

        return $this->redirect('/sat-cards/'.$satCard->id, true);
    }

    public function openModal()
    {
        return $this->storeModal = true;
    }

    public function closeDialog()
    {
        $this->resetErrorBag();

        return $this->storeModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.cards.create-satelit-card');
    }
}
