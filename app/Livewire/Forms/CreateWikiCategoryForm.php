<?php

namespace App\Livewire\Forms;

use App\Models\WikiCategory;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateWikiCategoryForm extends Form
{
    #[Validate('required', message: 'Vyplňte název kategorie')]
    #[Validate('unique:wiki_categories,name', message: 'Již existuje')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $name = '';

    public function create(): void
    {
        $this->validate();

        WikiCategory::create([
            'name' => $this->name,
        ]);

        $this->reset();
    }
}
