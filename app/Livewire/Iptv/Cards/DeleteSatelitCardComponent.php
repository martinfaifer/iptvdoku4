<?php

namespace App\Livewire\Iptv\Cards;

use App\Models\SatelitCard;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class DeleteSatelitCardComponent extends Component
{
    use NotificationTrait;

    public ?SatelitCard $satelitCard;

    public function destroy(): mixed
    {
        try {
            foreach ($this->satelitCard->contents as $content) {
                $content->delete();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        $this->satelitCard->delete();
        $this->redirect('/sat-cards', true);

        return $this->success_alert('Odebráno');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.iptv.cards.delete-satelit-card-component');
    }
}
