<?php

namespace App\Livewire\Iptv\Cards;

use App\Models\Device;
use Livewire\Component;
use App\Models\SatelitCard;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\SatelitCards\FindSatelitCardOnDeviceTemplateTrait;

class SatelitCardComponent extends Component
{
    use FindSatelitCardOnDeviceTemplateTrait, NotificationTrait;

    public ?SatelitCard $satelitCard;

    public Device|false $device;

    public bool $deviceInfoModal = false;

    public function mount(): void
    {
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
