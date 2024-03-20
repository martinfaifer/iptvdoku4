<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\WikiTopic;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class CreateWikiTopicForm extends Form
{
    #[Validate('required', message: "Vyplňte nadpis")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    public string $title = "";

    #[Validate('nullable')]
    #[Validate('string', message: "Neplatný formát")]
    public string $text = "";

    #[Validate('required', message: "Vyberte kategorii")]
    #[Validate('exists:wiki_categories,id', message: "Neexistující kategrie")]
    public $wiki_category_id = null;

    public function create()
    {
        $this->validate();

        $topic = WikiTopic::create([
            'title' => $this->title,
            'text' => $this->text,
            'wiki_category_id' => $this->wiki_category_id,
            'creator' => Auth::user()->email
        ]);

        $this->reset();

        return $topic;
    }
}
