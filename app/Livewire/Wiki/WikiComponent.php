<?php

namespace App\Livewire\Wiki;

use App\Models\WikiTopic;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class WikiComponent extends Component
{
    public mixed $topic = null;

    public function mount(mixed $topic = null): void
    {
        if (!blank($topic)) {
            if (!$topicModel = WikiTopic::where('id', $topic)->first()) {
                $this->redirect('/wiki', true);
            } else {
                $this->topic = $topicModel;
            }
        } else {
            $this->topic = $topic;
        }
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.wiki.wiki-component');
    }
}
