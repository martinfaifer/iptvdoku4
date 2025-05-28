<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\TagOnItem;
use Livewire\Attributes\Validate;

class StoreTagform extends Form
{
    #[Validate('required', message: 'Vyberte alespoň jeden štítek')]
    public array $selectedTags = [];

    public function submit(string|int $itemId, string $type)
    {
        $this->validate();
        foreach ($this->selectedTags as $selectedTag) {
            TagOnItem::create([
                'item_id' => $itemId,
                'type' => $type,
                'tag_id' => $selectedTag,
            ]);
        }
    }
}
