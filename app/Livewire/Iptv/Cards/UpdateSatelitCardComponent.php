<?php

namespace App\Livewire\Iptv\Cards;

use App\Livewire\Forms\UpdateSatelitCardForm;
use App\Models\SatelitCard;
use App\Models\SatelitCardVendor;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Livewire\Component;

class UpdateSatelitCardComponent extends Component
{
    use NotificationTrait;

    public UpdateSatelitCardForm $updateForm;

    public ?SatelitCard $satelitCard;

    public bool $updateModal = false;

    public Collection $satelitCardsVendors;

    public function mount(): void
    {
        $this->satelitCardsVendors = SatelitCardVendor::get();
    }

    public function edit(): void
    {
        $this->updateForm->set_satelit_card($this->satelitCard);

        $this->updateModal = true;
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->resetErrorBag();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function closeDialog(): void
    {
        $this->updateModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.cards.update-satelit-card-component');
    }
}
