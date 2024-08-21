<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\SatelitCardContent;

class StoreSatelitCardContentForm extends Form
{
    use WithFileUploads;

    #[Validate('required', message: "Vyberte soubor")]
    #[Validate('max:2048', message: "Maximální velikost je :max")]
    public mixed $file;

    public function create(int $satCardId): void
    {
        $validated = $this->validate();
        $path = $this->file->store(path: 'public/sat-cards');
        SatelitCardContent::create([
            'satelit_card_id' => $satCardId,
            'file_name' => $this->file->getClientOriginalName(),
            'path' => $path
        ]);
    }
}
