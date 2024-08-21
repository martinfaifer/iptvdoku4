<?php

namespace App\Livewire\Forms;

use App\Models\WikiTopic;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateWikiTopicForm extends Form
{
    #[Validate('required', message: 'Vyplňte nadpis')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $title = '';

    #[Validate('nullable')]
    #[Validate('string', message: 'Neplatný formát')]
    public string $text = '';

    #[Validate('required', message: 'Vyberte kategorii')]
    #[Validate('exists:wiki_categories,id', message: 'Neexistující kategrie')]
    public int|null $wiki_category_id = null;

    public function create(): mixed
    {
        $this->validate();

        $topic = WikiTopic::create([
            'title' => $this->title,
            'text' => $this->text,
            'wiki_category_id' => $this->wiki_category_id,
            'creator' => Auth::user()->email,
        ]);

        $this->reset();

        return $topic;
    }
}
