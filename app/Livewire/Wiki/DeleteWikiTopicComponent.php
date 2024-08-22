<?php

namespace App\Livewire\Wiki;

use App\Models\WikiTopic;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class DeleteWikiTopicComponent extends Component
{
    use NotificationTrait;
    public ?int $id = null;
    public function destroy(): mixed
    {
        $this->redirect("/wiki", true);
        WikiTopic::find($this->id)->delete();
        return $this->success_alert('Odebrán článek');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.wiki.delete-wiki-topic-component');
    }
}
