<?php

namespace App\Livewire\Iptv\Cards;

use App\Models\Device;
use Livewire\Component;
use App\Models\SatelitCard;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\SatelitCards\FindSatelitCardOnDeviceTemplateTrait;

class SatelitCardComponent extends Component
{
    use NotificationTrait, FindSatelitCardOnDeviceTemplateTrait;

    public ?SatelitCard $satelitCard;
    public $device;

    public bool $deviceInfoModal = false;

    public function mount()
    {
        rescue(function () {
            $this->device = $this->find_card_in_device_template($this->satelitCard);
        });
    }

    public function openModal()
    {
        return $this->deviceInfoModal = true;
    }

    public function closeModal()
    {
        return $this->deviceInfoModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.cards.satelit-card-component');
    }
}