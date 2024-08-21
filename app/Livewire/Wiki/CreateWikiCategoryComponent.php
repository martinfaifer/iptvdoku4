<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateWikiCategoryForm;

class CreateWikiCategoryComponent extends Component
{
    use NotificationTrait;

    public CreateWikiCategoryForm $form;

    public bool $storeModal = false;

    public function create(): mixed
    {
        $this->form->create();

        $this->dispatch('refresh_wiki_menu');

        $this->closeDialog();

        return $this->success_alert('Kategorie přidána');
    }

    public function openModal(): void
    {
        $this->resetErrorBag();

        $this->storeModal = true;
    }

    public function closeDialog(): void
    {
        $this->storeModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.wiki.create-wiki-category-component');
    }
}
