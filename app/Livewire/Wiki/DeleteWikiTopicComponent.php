<?php

namespace App\Livewire\Wiki;

use App\Models\WikiTopic;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class DeleteWikiTopicComponent extends Component
{
    use NotificationTrait;

    public ?WikiTopic $topic;

    public function destroy()
    {
        $this->topic->delete();

        $this->redirect(url()->previous(), true);

        return $this->success_alert("Odebrán článek");
    }

    public function render()
    {
        return view('livewire.wiki.delete-wiki-topic-component');
    }
}
