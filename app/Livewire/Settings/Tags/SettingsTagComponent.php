<?php

namespace App\Livewire\Settings\Tags;

use App\Models\CssColor;
use App\Models\Tag;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsTagComponent extends Component
{
    use NotificationTrait, WithPagination;

    public bool $createModal = false;

    public string $query = '';

    #[Validate('required', message: 'Vyplňte název')]
    public string $name = '';

    #[Validate('required', message: 'Vyberte barvu')]
    public string $color = '';

    public Collection $cssColors;

    public function mount(): void
    {
        $this->cssColors = CssColor::get();
    }

    public function openCreateModal(): void
    {
        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();
        Tag::create([
            'name' => $this->name,
            'color' => CssColor::find($this->color)->color,
        ]);

        $this->success_alert('Přidáno');
        $this->closeDialog();
    }

    public function destroy(Tag $tag): mixed
    {
        if ($tag->items->isEmpty()) {
            $tag->delete();
            $this->dispatch('refresh-settings-tags');

            return $this->success_alert('Odebráno');
        }

        return $this->error_alert('Štítek má vazbu');
    }

    public function closeDialog(): void
    {
        $this->createModal = false;
        $this->dispatch('refresh-settings-tags');
    }

    #[On('refresh-settings-tags')]
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.tags.settings-tag-component', [
            'tags' => Tag::search($this->query)->paginate(5),
            'headers' => [
                ['key' => 'name', 'label' => 'Název', 'class' => 'dark:text-white/80'],
                ['key' => 'color', 'label' => 'Barva', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
