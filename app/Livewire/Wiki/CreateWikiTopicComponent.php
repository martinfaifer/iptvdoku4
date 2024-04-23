<?php

namespace App\Livewire\Wiki;

use App\Livewire\Forms\CreateWikiTopicForm;
use App\Models\WikiCategory;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class CreateWikiTopicComponent extends Component
{
    use NotificationTrait;

    public CreateWikiTopicForm $form;

    public bool $storeModal = false;

    public array $categories;

    public function mount()
    {
        $this->categories = WikiCategory::get()->toArray();
    }

    public function create()
    {
        $topic = $this->form->create();

        $this->redirect(url()->previous(), true);

        return $this->success_alert("Článek vytvořen");
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
        return view('livewire.wiki.create-wiki-topic-component');
    }
}
