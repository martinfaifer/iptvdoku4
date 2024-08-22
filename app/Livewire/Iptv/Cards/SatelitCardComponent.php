<?php

namespace App\Livewire\Iptv\Cards;

use App\Models\Device;
use App\Models\SatelitCard;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\SatelitCards\FindSatelitCardOnDeviceTemplateTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class SatelitCardComponent extends Component
{
    use FindSatelitCardOnDeviceTemplateTrait, NotificationTrait;

    public mixed $satelitCard = null;

    public Device|false $device;

    public bool $deviceInfoModal = false;

    public function mount(mixed $satelitCard = null): void
    {
        if (!blank($satelitCard)) {
            if (!$satelitCardModel = SatelitCard::where('id', $satelitCard)->first()) {
                $this->redirect('/sat-cards', true);
            } else {
                $this->satelitCard = $satelitCardModel;
            }
        } else {
            $this->satelitCard = $satelitCard;
        }
        try {
            $this->device = $this->find_card_in_device_template($this->satelitCard);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function openModal(): void
    {
        $this->deviceInfoModal = true;
    }

    public function closeModal(): void
    {
        $this->deviceInfoModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.cards.satelit-card-component');
    }
}
