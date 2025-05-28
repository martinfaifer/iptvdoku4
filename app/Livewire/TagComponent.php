<?php

namespace App\Livewire;

use App\Livewire\Forms\StoreTagform;
use App\Models\Tag;
use App\Models\TagOnItem;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TagComponent extends Component
{
    use NotificationTrait;

    public StoreTagform $form;

    public Collection $tags;

    public Collection $tagsOnItem;

    public string $type;

    public int $itemId = 0;

    // #[Validate('required', message: 'Vyberte alespoň jeden štítek')]
    // public array $selectedTags = [];

    public bool $storeModal = false;

    public function mount(string $type, int $itemId): void
    {
        $this->tags = Tag::get(['id', 'name']);
        $this->type = $type;
        $this->itemId = $itemId;
        // $this->tagsOnItem = TagOnItem::where('type', $type)->where('item_id', $itemId)->with('tag')->get();
    }

    public function openModal(): void
    {
        $this->storeModal = true;
    }

    #[Computed()]
    public function getTags(): Collection
    {
        return TagOnItem::where('type', $this->type)->where('item_id', $this->itemId)->with('tag')->get();
    }

    public function closeDialog(): void
    {
        $this->form->reset();
        $this->storeModal = false;
    }

    public function store(): mixed
    {
        $this->form->submit(
            itemId: $this->itemId,
            type: $this->type
        );

        $this->dispatch('tag-component.' . $this->type . '.' . $this->itemId);
        if ($this->type == 'device') {
            $this->dispatch('check_if_need_ssh.' . $this->itemId);
        }
        $this->closeDialog();

        return $this->success_alert('Upraveno');
    }

    public function destroy(TagOnItem $tagOnItem): mixed
    {
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
