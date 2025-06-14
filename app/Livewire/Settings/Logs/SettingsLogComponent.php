<?php

namespace App\Livewire\Settings\Logs;

use App\Models\Loger;
use App\Traits\Loger\ShowCorrectNameOfItemTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsLogComponent extends Component
{
    use ShowCorrectNameOfItemTrait, WithPagination;

    public string $query = '';

    public bool $detailModal = false;

    public array $selectedLogDetail = [];

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    public function show(array $payload, mixed $logId): void
    {
        $this->selectedLogDetail = $payload;
        $this->detailModal = true;
    }

    public function closeModal(): void
    {
        $this->selectedLogDetail = [];
        $this->detailModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.logs.settings-log-component', [
            'logs' => Loger::search($this->query)->orderBy(...array_values($this->sortBy))->paginate(10),
            'headers' => [
                ['key' => 'user', 'label' => 'Uživatel', 'class' => 'dark:text-white/80'],
                ['key' => 'type', 'label' => 'Typ události', 'class' => 'dark:text-white/80'],
                ['key' => 'item', 'label' => 'Předmět', 'class' => 'dark:text-white/80'],
                // ['key' => 'payload', 'label' => 'Payload', 'class' => 'dark:text-white/80'],
                ['key' => 'created_at', 'label' => 'Vytvořeno', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
