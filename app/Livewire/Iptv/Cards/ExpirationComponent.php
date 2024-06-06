<?php

namespace App\Livewire\Iptv\Cards;

use App\Livewire\Forms\CreateSatelitCardExpirationForm;
use App\Livewire\Forms\UpdateSatelitCardExpirationForm;
use App\Models\SatelitCard;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class ExpirationComponent extends Component
{
    use NotificationTrait;

    public ?SatelitCard $satelitCard;

    public CreateSatelitCardExpirationForm $createForm;

    public UpdateSatelitCardExpirationForm $updateForm;

    public bool $storeModal = false;

    public bool $editModal = false;

    public function mount(SatelitCard $satelitCard)
    {
        $this->satelitCard = $satelitCard;
    }

    public function openStoreModal()
    {
        return $this->storeModal = true;
    }

    public function openEditModal()
    {
        $this->updateForm->setSatelitCard($this->satelitCard);

        return $this->editModal = true;
    }

    public function closeModal()
    {
        $this->createForm->reset();
        $this->updateForm->reset();
        $this->editModal = false;

        return $this->storeModal = false;
    }

    public function create()
    {
        $this->createForm->create($this->satelitCard);

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Expirace přidána');
    }

    public function update()
    {
        $this->updateForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Expirace upravena');
    }

    public function destroy()
    {
        $this->satelitCard->update([
            'expiration' => null,
        ]);

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Expirace odebrána');
    }

    public function render()
    {
        return view('livewire.iptv.cards.expiration-component');
    }
}
