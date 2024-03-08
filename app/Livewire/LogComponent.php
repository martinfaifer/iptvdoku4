<?php

namespace App\Livewire;

use App\Services\Logger\LoggerService;
use Livewire\Component;

class LogComponent extends Component
{
    public $columnValue;

    public $column;

    public $logs;

    public array $selectedLogDetail;

    public bool $detailModal = false;

    public function mount()
    {
        $this->logs = (new LoggerService())->show($this->column, columnValue: $this->columnValue);
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

    public function render()
    {
        return view('livewire.log-component');
    }
}
