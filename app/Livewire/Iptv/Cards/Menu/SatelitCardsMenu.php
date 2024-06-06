<?php

namespace App\Livewire\Iptv\Cards\Menu;

use App\Models\SatelitCardVendor;
use Livewire\Attributes\On;
use Livewire\Component;

class SatelitCardsMenu extends Component
{
    public $satelitCardsWithVendor;

    public function mount()
    {
        $this->loadSatCards();
    }

    #[On('update_satelit_cards_menu')]
    public function loadSatCards()
    {
        $this->satelitCardsWithVendor = SatelitCardVendor::with('satelit_cards')->get();
    }

    public function render()
    {
        return view('livewire.iptv.cards.menu.satelit-cards-menu');
    }
}
