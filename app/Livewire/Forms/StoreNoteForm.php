<?php

namespace App\Livewire\Forms;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;

class StoreNoteForm extends Form
{
    public ?string $note = '';

    public function rules()
    {
        return [
            'note' => ['required', 'string'],
        ];
    }

    public function messeges()
    {
        return [
            'note.required' => 'Napište poznámku',
            'note.string' => 'Neplatný formát',
        ];
    }

    public function store($column, $id)
    {
        $this->validate();
        Note::create([
            $column => $id,
            'note' => $this->note,
            'user' => Auth::user()->email,
        ]);

        $this->reset();
    }
}
