<?php

namespace App\Livewire\Iptv\Cards;

use App\Models\SatelitCard;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class DeleteSatelitCardComponent extends Component
{
    use NotificationTrait;

    public ?SatelitCard $satelitCard;

    public function destroy()
    {
        try {
            $this->satelitCard->contents->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        $this->satelitCard->delete();
        $this->redirect('/sat-cards', true);

        return $this->success_alert('Odebráno');
    }

    public function render()
    {
        return view('livewire.iptv.cards.delete-satelit-card-component');
    }
}
