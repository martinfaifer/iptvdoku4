<?php

namespace App\Livewire\Notes;

use App\Models\Note;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Forms\StoreNoteForm;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;

class NoteComponent extends Component
{
    use NotificationTrait;

    public StoreNoteForm $storeNoteForm;

    public string $column;

    public string|int $id;

    public bool $storeModal = false;

    public function openModal(): void
    {
        $this->storeNoteForm->note = "";
        $this->storeModal = true;
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col gap-4 w-52">
                <div class="skeleton h-32 w-full"></div>
                <div class="skeleton h-4 w-28"></div>
                <div class="skeleton h-4 w-full"></div>
                <div class="skeleton h-4 w-full"></div>
            </div>
        </div>
        HTML;
    }

    public function store(): mixed
    {
        $this->storeNoteForm->store($this->column, $this->id);
        $this->dispatch('update_notes.' . $this->column . $this->id);
        $this->closeDialog();

        return $this->success_alert('Přidáno');
    }

    public function closeDialog(): void
    {
        $this->storeModal = false;
        $this->resetErrorBag();
    }

    public function destroy(Note $note): mixed
    {
        $note->delete();
        $this->dispatch('update_notes.' . $this->column . $this->id);

        return $this->success_alert('Poznámka odebrána');
    }

    #[On('update_notes.{column}{id}')]
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.notes.note-component', [
            'notes' => Note::where($this->column, $this->id)->orderBy('id', 'DESC')->get(),
        ]);
    }
}
