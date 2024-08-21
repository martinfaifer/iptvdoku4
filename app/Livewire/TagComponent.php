<?php

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Component;
use App\Models\TagOnItem;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;

class TagComponent extends Component
{
    use NotificationTrait;

    public Collection $tags;

    public Collection $tagsOnItem;

    public string $type;

    public int $itemId = 0;

    #[Validate('required', message: 'Vyberte alespoň jeden štítek')]
    public array $selectedTags = [];

    public bool $storeModal = false;

    public function mount(string $type, int $itemId): void
    {
        $this->tags = Tag::get();
        $this->type = $type;
        $this->itemId = $itemId;
        $this->tagsOnItem = TagOnItem::where('type', $type)->where('item_id', $itemId)->with('tag')->get();
    }

    public function openModal(): void
    {
        $this->storeModal = true;
    }

    public function closeDialog(): void
    {
        $this->reset('selectedTags');

        $this->storeModal = false;
    }

    public function store(): mixed
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

    public function destroy(TagOnItem $tagOnItem): mixed
    {
        $tag = $tagOnItem->tag;
        $tagOnItem->delete();
        $this->dispatch('tag-component.' . $this->type . '.' . $this->itemId);

        return $this->success_alert('Upraveno');
    }

    #[On('tag-component.{type}.{itemId}')]
    public function refreshTags(): void
    {
        $this->tagsOnItem = TagOnItem::where('type', $this->type)->where('item_id', $this->itemId)->with('tag')->get();
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.tag-component');
    }
}
