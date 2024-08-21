<?php

namespace App\Livewire\Forms;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StoreNoteForm extends Form
{
    #[Validate('required', message: "Vyplňte poznámku")]
    #[Validate('string', message: "Neplatný formát")]
    public string $note = '';

    public function store(string $column, string $id): void
    {
        $this->validate();
        Note::create([
            $column => $id,
            'note' => $this->note,
            'user' => Auth::user()->email,
        ]);

        $this->note = "";
    }
}
