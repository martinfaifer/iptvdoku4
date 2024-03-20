<?php

namespace App\Livewire\Wiki;

use App\Livewire\Forms\CreateWikiCategoryForm;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class CreateWikiCategoryComponent extends Component
{
    use NotificationTrait;

    public CreateWikiCategoryForm $form;

    public bool $storeModal = false;

    public function create()
    {
        $this->form->create();

        $this->dispatch("refresh_wiki_menu");

        $this->closeDialog();

        return $this->success_alert("Kategorie přidána");
    }

    public function openModal()
    {
        $this->resetErrorBag();
        return $this->storeModal = true;
    }

    public function closeDialog()
    {
        return $this->storeModal = false;
    }

    public function render()
    {
        return view('livewire.wiki.create-wiki-category-component');
    }
}
