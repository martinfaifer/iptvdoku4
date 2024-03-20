<?php

namespace App\Livewire\Wiki\Menu;

use App\Models\WikiCategory;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

class WikiMenuComponent extends Component
{

    public Collection $categoriesWithTopicsNames;

    public function mount()
    {
        $this->categoriesWithTopicsNames = WikiCategory::with('topics:id,title,wiki_category_id')->get();
    }

    #[On('refresh_wiki_menu')]
    public function refreshCategoriesWithTopicsNames()
    {
        $this->categoriesWithTopicsNames = WikiCategory::with('topics:id,title,wiki_category_id')->get();
    }

    public function render()
    {
        return view('livewire.wiki.menu.wiki-menu-component');
    }
}
