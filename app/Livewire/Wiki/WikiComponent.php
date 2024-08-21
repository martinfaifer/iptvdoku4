<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use App\Models\WikiTopic;
use Illuminate\Contracts\View\Factory;

class WikiComponent extends Component
{
    public ?WikiTopic $topic;

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.wiki.wiki-component');
    }
}
