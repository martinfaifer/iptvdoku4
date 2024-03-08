<?php

namespace App\Livewire\Iptv\Cards;

use App\Models\SatelitCard;
use Livewire\Component;
use App\Traits\Livewire\NotificationTrait;

class SatelitCardComponent extends Component
{
    use NotificationTrait;


    public ?SatelitCard $satelitCard;

    public function render()
    {
        return view('livewire.iptv.cards.satelit-card-component');
    }
}
