<?php

namespace App\Livewire\Wiki;

use Livewire\Component;
use App\Models\WikiTopic;
use App\Models\WikiCategory;
use App\Livewire\Forms\UpdateWikiTopicForm;
use App\Traits\Livewire\NotificationTrait;

class UpdateWikiTopicComponent extends Component
{
    use NotificationTrait;

    public UpdateWikiTopicForm $form;

    public ?WikiTopic $topic;

    public bool $updateModal = false;

    public array $categories;

    public function mount()
    {
        $this->categories = WikiCategory::get()->toArray();
    }

    public function edit()
    {
        $this->form->setTopic($this->topic);
        return $this->updateModal = true;
    }

    public function update()
    {
        $this->form->update();

        $this->redirect("/wiki/" . $this->topic->id, true);
        return $this->success_alert("Upraveno");
    }

    public function closeDialog()
    {
        $this->resetErrorBag();
        $this->updateModal = false;
    }

    public function render()
    {
        return view('livewire.wiki.update-wiki-topic-component');
    }
}