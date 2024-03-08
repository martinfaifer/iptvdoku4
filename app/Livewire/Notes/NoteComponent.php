<?php

namespace App\Livewire\Notes;

use App\Livewire\Forms\StoreNoteForm;
use App\Models\Note;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Attributes\On;
use Livewire\Component;

class NoteComponent extends Component
{
    use NotificationTrait;

    public StoreNoteForm $storeNoteForm;

    public string $column;

    public $id;

    public bool $storeModal = false;

    public function openModal()
    {
        $this->storeModal = true;
    }

    public function store()
    {
        $this->storeNoteForm->store($this->column, $this->id);
        $this->dispatch('update_notes.'.$this->column.$this->id);
        $this->closeDialog();

        return $this->success_alert('Přidáno');
    }

    public function closeDialog()
    {
        $this->storeModal = false;
        $this->resetErrorBag();
    }

    public function destroy(Note $note)
    {
        $note->delete();
        $this->dispatch('update_notes.'.$this->column.$this->id);

        return $this->success_alert('Poznámka odebrána');
    }

    #[On('update_notes.{column}{id}')]
    public function render()
    {
        return view('livewire.notes.note-component', [
            'notes' => Note::where($this->column, $this->id)->orderBy('id', 'DESC')->get(),
        ]);
    }
}
