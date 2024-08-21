<?php

namespace App\Livewire\Forms;

use App\Models\SatelitCardContent;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class StoreSatelitCardContentForm extends Form
{
    use WithFileUploads;

    #[Validate('required', message: 'Vyberte soubor')]
    #[Validate('max:2048', message: 'Maximální velikost je :max')]
    public mixed $file;

    public function create(int $satCardId): void
    {
        $validated = $this->validate();
        $path = $this->file->store(path: 'public/sat-cards');
        SatelitCardContent::create([
            'satelit_card_id' => $satCardId,
            'file_name' => $this->file->getClientOriginalName(),
            'path' => $path,
        ]);
    }
}
