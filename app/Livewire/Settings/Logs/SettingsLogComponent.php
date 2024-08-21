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

    public string $selectedLogDetail = '';

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    public function show(string $payload, mixed $logId): void
    {
        $this->selectedLogDetail = $payload;
        $this->detailModal = true;
    }

    public function closeModal(): void
    {
        $this->selectedLogDetail = '';
        $this->detailModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.logs.settings-log-component', [
            'logs' => Loger::search($this->query)->orderBy(...array_values($this->sortBy))->paginate(10),
            'headers' => [
                ['key' => 'user', 'label' => 'Uživatel', 'class' => 'text-white/80'],
                ['key' => 'type', 'label' => 'Typ události', 'class' => 'text-white/80'],
                ['key' => 'item', 'label' => 'Předmět', 'class' => 'text-white/80'],
                // ['key' => 'payload', 'label' => 'Payload', 'class' => 'text-white/80'],
                ['key' => 'created_at', 'label' => 'Vytvořeno', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
