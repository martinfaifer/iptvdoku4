<?php

namespace App\Livewire\Iptv\Cards;

use App\Livewire\Forms\UpdateSatelitCardForm;
use App\Models\SatelitCard;
use App\Models\SatelitCardVendor;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Collection;
use Livewire\Component;

class UpdateSatelitCardComponent extends Component
{
    use NotificationTrait;

    public UpdateSatelitCardForm $updateForm;

    public ?SatelitCard $satelitCard;

    public bool $updateModal = false;

    public Collection $satelitCardsVendors;

    public function mount()
    {
        $this->satelitCardsVendors = SatelitCardVendor::get();
    }

    public function edit()
    {
        $this->updateForm->set_satelit_card($this->satelitCard);

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->resetErrorBag();

        $this->success_alert('Upraveno');

        return $this->redirect('/sat-cards/'.$this->satelitCard->id);
    }

    public function closeDialog()
    {
        $this->updateModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.cards.update-satelit-card-component');
    }
}
