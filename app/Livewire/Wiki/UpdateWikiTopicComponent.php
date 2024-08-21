<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use App\Models\WikiTopic;
use App\Models\WikiCategory;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\UpdateWikiTopicForm;

class UpdateWikiTopicComponent extends Component
{
    use NotificationTrait;

    public UpdateWikiTopicForm $form;

    public ?WikiTopic $topic;

    public bool $updateModal = false;

    public array $categories;

    public function mount(): void
    {
        $this->categories = WikiCategory::get()->toArray();
    }

    public function edit(): void
    {
        $this->form->setTopic($this->topic);

        $this->updateModal = true;
    }

    public function update(): mixed
    {
        $this->form->update();

        $this->redirect(url()->previous(), true);
        $this->dispatch('refresh_wiki_menu');

        return $this->success_alert('Upraveno');
    }

    public function closeDialog(): void
    {
        $this->resetErrorBag();
        $this->updateModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.wiki.update-wiki-topic-component');
    }
}
