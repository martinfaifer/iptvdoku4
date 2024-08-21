<?php

namespace App\Livewire\Iptv\Cards\Menu;

use App\Models\SatelitCardVendor;
use Illuminate\Contracts\View\Factory;
use Livewire\Attributes\On;
use Livewire\Component;

class SatelitCardsMenu extends Component
{
    public mixed $satelitCardsWithVendor;

    public function mount(): void
    {
        $this->loadSatCards();
    }

    #[On('update_satelit_cards_menu')]
    public function loadSatCards(): void
    {
        $this->satelitCardsWithVendor = SatelitCardVendor::with('satelit_cards')->get();
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.cards.menu.satelit-cards-menu');
    }
}
