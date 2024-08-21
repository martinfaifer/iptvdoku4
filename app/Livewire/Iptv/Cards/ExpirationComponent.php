<?php

namespace App\Livewire\Iptv\Cards;

use App\Livewire\Forms\CreateSatelitCardExpirationForm;
use App\Livewire\Forms\UpdateSatelitCardExpirationForm;
use App\Models\SatelitCard;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class ExpirationComponent extends Component
{
    use NotificationTrait;

    public ?SatelitCard $satelitCard;

    public CreateSatelitCardExpirationForm $createForm;

    public UpdateSatelitCardExpirationForm $updateForm;

    public bool $storeModal = false;

    public bool $editModal = false;

    public function mount(SatelitCard $satelitCard): void
    {
        $this->satelitCard = $satelitCard;
    }

    public function openStoreModal(): void
    {
        $this->storeModal = true;
    }

    public function openEditModal(): void
    {
        $this->updateForm->setSatelitCard($this->satelitCard);

        $this->editModal = true;
    }

    public function closeDialog(): void
    {
        $this->createForm->reset();
        $this->updateForm->reset();
        $this->editModal = false;

        $this->storeModal = false;
    }

    public function create(): mixed
    {
        $this->createForm->create($this->satelitCard);

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Expirace přidána');
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Expirace upravena');
    }

    public function destroy(): mixed
    {
        $this->satelitCard->update([
            'expiration' => null,
        ]);

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Expirace odebrána');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.cards.expiration-component');
    }
}
