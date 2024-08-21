<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use App\Models\WikiTopic;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;

class DeleteWikiTopicComponent extends Component
{
    use NotificationTrait;

    public ?WikiTopic $topic;

    public function destroy(): mixed
    {
        $this->topic->delete();

        $this->redirect(url()->previous(), true);
        $this->dispatch('refresh_wiki_menu');

        return $this->success_alert('Odebrán článek');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.wiki.delete-wiki-topic-component');
    }
}
