<?php

namespace App\Livewire\Iptv\Cards;

use App\Models\SatelitCard;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class SatelitCardComponent extends Component
{
    use NotificationTrait;

    public ?SatelitCard $satelitCard;

    public function render()
    {
        return view('livewire.iptv.cards.satelit-card-component');
    }
}
