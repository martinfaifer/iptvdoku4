<?php

namespace App\Livewire\Iptv\Cards;

use Livewire\Component;
use App\Models\SatelitCard;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;

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
