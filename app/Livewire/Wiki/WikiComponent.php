<?php

namespace App\Livewire\Wiki;

use App\Models\WikiTopic;
use Livewire\Component;

class WikiComponent extends Component
{

    public ?WikiTopic $topic;

    public function render()
    {
        return view('livewire.wiki.wiki-component');
    }
}
