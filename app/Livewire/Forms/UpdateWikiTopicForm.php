<?php

namespace App\Livewire\Forms;

use App\Models\WikiTopic;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateWikiTopicForm extends Form
{
    public ?WikiTopic $topic;

    #[Validate('required', message: 'Vyplňte nadpis')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $title = '';

    #[Validate('nullable')]
    #[Validate('string', message: 'Neplatný formát')]
    public string $text = '';

    #[Validate('required', message: 'Vyberte kategorii')]
    #[Validate('exists:wiki_categories,id', message: 'Neexistující kategrie')]
    public $wiki_category_id = null;

    public function setTopic(WikiTopic $topic)
    {
        $this->topic = $topic;
        $this->title = $topic->title;
        $this->text = $topic->text;
        $this->wiki_category_id = $topic->wiki_category_id;
    }

    public function update()
    {
        $this->topic->update([
            'title' => $this->title,
            'text' => $this->text,
            'wiki_category_id' => $this->wiki_category_id,
        ]);

        $this->reset();
    }
}
