<?php

namespace App\Livewire\Wiki;

use App\Livewire\Forms\CreateWikiTopicForm;
use App\Models\WikiCategory;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class CreateWikiTopicComponent extends Component
{
    use NotificationTrait;

    public CreateWikiTopicForm $form;

    public bool $storeModal = false;

    public array $categories;

    public function mount(): void
    {
        $this->categories = WikiCategory::get()->toArray();
    }

    public function create(): mixed
    {
        $topic = $this->form->create();

        $this->redirect(url()->previous(), true);
        $this->dispatch('refresh_wiki_menu');

        return $this->success_alert('Článek vytvořen');
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
        return view('livewire.wiki.create-wiki-topic-component');
    }
}
