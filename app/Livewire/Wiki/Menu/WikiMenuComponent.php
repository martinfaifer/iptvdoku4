<?php

namespace App\Livewire\Wiki\Menu;

use App\Models\WikiCategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class WikiMenuComponent extends Component
{
    public Collection $categoriesWithTopicsNames;

    public function mount(): void
    {
        $this->categoriesWithTopicsNames = WikiCategory::with('topics:id,title,wiki_category_id')->get();
    }

    #[On('refresh_wiki_menu')]
    public function refreshCategoriesWithTopicsNames(): void
    {
        $this->categoriesWithTopicsNames = WikiCategory::with('topics:id,title,wiki_category_id')->get();
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.wiki.menu.wiki-menu-component');
    }
}
