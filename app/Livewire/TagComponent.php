<?php

namespace App\Livewire;

use App\Models\Tag;
use App\Models\TagOnItem;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TagComponent extends Component
{
    use NotificationTrait;

    public Collection $tags;

    public Collection $tagsOnItem;

    public $type;

    public $itemId;

    #[Validate('required', message: 'Vyberte alespoň jeden štítek')]
    public array $selectedTags = [];

    public bool $storeModal = false;

    public function mount(string $type, int $itemId)
    {
        $this->tags = Tag::get();
        $this->type = $type;
        $this->itemId = $itemId;
        $this->tagsOnItem = TagOnItem::where('type', $type)->where('item_id', $itemId)->with('tag')->get();
    }

    public function openModal()
    {
        return $this->storeModal = true;
    }

    public function closeDialog()
    {
        $this->reset('selectedTags');

        return $this->storeModal = false;
    }

    public function store()
    {
        $this->validate();
        foreach ($this->selectedTags as $selectedTag) {
            TagOnItem::create([
                'item_id' => $this->itemId,
                'type' => $this->type,
                'tag_id' => $selectedTag,
            ]);
        }

        $this->dispatch('tag-component.' . $this->type . '.' . $this->itemId);
        if ($this->type == 'device') {
            $this->dispatch('check_if_need_ssh.' . $this->itemId);
        }
        $this->closeDialog();

        return $this->success_alert('Upraveno');
    }

    public function destroy(TagOnItem $tagOnItem)
    {
        $tag = $tagOnItem->tag;
        $tagOnItem->delete();
        $this->dispatch('tag-component.' . $this->type . '.' . $this->itemId);

        return $this->success_alert('Upraveno');
    }

    #[On('tag-component.{type}.{itemId}')]
    public function refreshTags()
    {
        return $this->tagsOnItem = TagOnItem::where('type', $this->type)->where('item_id', $this->itemId)->with('tag')->get();
    }

    public function render()
    {
        return view('livewire.tag-component');
    }
}
