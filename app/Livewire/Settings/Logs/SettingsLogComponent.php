<?php

namespace App\Livewire\Settings\Logs;

use App\Models\Loger;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\Loger\ShowCorrectNameOfItemTrait;

class SettingsLogComponent extends Component
{
    use WithPagination, ShowCorrectNameOfItemTrait;
    public string $query = '';

    public bool $detailModal = false;

    public $selectedLogDetail = "";

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];

    public function show($payload, $logId)
    {
        $this->selectedLogDetail = $payload;
        $this->detailModal = true;
    }

    public function closeModal()
    {
        $this->selectedLogDetail = null;
        $this->detailModal = false;
    }

    public function render()
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
