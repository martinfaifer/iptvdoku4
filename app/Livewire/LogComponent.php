<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Services\Logger\LoggerService;

class LogComponent extends Component
{
    public $columnValue;

    public $column;

    public $logs;

    public array $selectedLogDetail;

    public bool $detailModal = false;

    public function mount()
    {
        $this->refreshLogs();
    }

    public function openModal($payload)
    {
        $this->selectedLogDetail = $payload;

        return $this->detailModal = true;
    }

    public function closeModal()
    {
        $this->selectedLogDetail = [];

        return $this->detailModal = false;
    }

    #[On('echo:refresh_logs_{column}_{columnValue},BroadcastLogEvent')]
    public function refreshLogs()
    {
        return $this->logs = (new LoggerService())->show($this->column, columnValue: $this->columnValue);
    }

    public function render()
    {
        return view('livewire.log-component');
    }
}
