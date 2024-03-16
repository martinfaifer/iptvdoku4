<?php

namespace App\Livewire\Settings\Tags;

use App\Models\CssColor;
use App\Models\Tag;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsTagComponent extends Component
{
    use NotificationTrait, WithPagination;

    public bool $createModal = false;

    public $query = '';

    #[Validate('required', message: 'Vyplňte název')]
    public string $name = '';

    #[Validate('required', message: 'Vyberte barvu')]
    public string $color = '';

    public Collection $cssColors;

    public function mount()
    {
        $this->cssColors = CssColor::get();
    }

    public function openCreateModal()
    {
        return $this->createModal = true;
    }

    public function create()
    {
        $this->validate();
        Tag::create([
            'name' => $this->name,
            'color' => CssColor::find($this->color)->color,
        ]);

        $this->success_alert('Přidáno');
        $this->closeDialog();
    }

    public function destroy(Tag $tag)
    {
        if ($tag->items->isEmpty()) {
            $tag->delete();
            $this->dispatch('refresh-settings-tags');

            return $this->success_alert('Odebráno');
        }

        return $this->error_alert('Štítek má vazbu');
    }

    public function closeDialog()
    {
        $this->createModal = false;
        $this->dispatch('refresh-settings-tags');
    }

    #[On('refresh-settings-tags')]
    public function render()
    {
        return view('livewire.settings.tags.settings-tag-component', [
            'tags' => Tag::search($this->query)->paginate(5),
            'headers' => [
                ['key' => 'name', 'label' => 'Název', 'class' => 'text-white/80'],
                ['key' => 'color', 'label' => 'Barva', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
