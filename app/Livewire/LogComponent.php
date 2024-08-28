<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use App\Services\Logger\LoggerService;
use Illuminate\Contracts\View\Factory;

class LogComponent extends Component
{
    #[Locked]
    public string $columnValue;

    #[Locked]
    public string $column;

    public mixed $logs;

    public array $selectedLogDetail;

    public bool $detailModal = false;

    public function mount(): void
    {
        $this->refreshLogs();
    }

    public function openModal(array $payload): void
    {
        $this->selectedLogDetail = $payload;

        $this->detailModal = true;
    }

    public function closeModal(): void
    {
        $this->selectedLogDetail = [];

        $this->detailModal = false;
    }

    public function placeholder(): string
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col gap-4 w-52">
                <div class="skeleton h-32 w-full"></div>
                <div class="skeleton h-4 w-28"></div>
                <div class="skeleton h-4 w-full"></div>
                <div class="skeleton h-4 w-full"></div>
            </div>
        </div>
        HTML;
    }

    #[On('echo:refresh_logs_{column}_{columnValue},BroadcastLogEvent')]
    public function refreshLogs(): void
    {
        $this->logs = (new LoggerService())->show($this->column, columnValue: $this->columnValue);
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.log-component');
    }
}
