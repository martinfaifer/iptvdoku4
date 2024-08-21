<?php

namespace App\Livewire\Settings\Geniustv\Invoices;

use App\Models\NanguIspInvoice;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsGeniusTvInvoicesComponent extends Component
{
    use WithPagination;

    public string $selectedDate;

    public string $query = '';

    public int $selectedInvoiceMonth;

    public int $selectedInvoiceYear;

    public array $availableInvoiceDates;

    public function mount(): void
    {
        $this->selectedInvoiceMonth = now()->month;
        $this->selectedInvoiceYear = now()->year;
        if ($this->selectedInvoiceMonth < 10) {
            $this->selectedDate = $this->selectedInvoiceYear.'-0'.$this->selectedInvoiceMonth;
        } else {
            $this->selectedDate = $this->selectedInvoiceYear.'-'.$this->selectedInvoiceMonth;
        }
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        $dateArray = explode('-', $this->selectedDate);

        return view('livewire.settings.genius-tv.invoices.settings-genius-tv-invoices-component', [
            'invoicesForSelectedDate' => NanguIspInvoice::with('nanguIsp')
                ->search($this->query)
                ->whereMonth('created_at', $dateArray[1])
                ->whereYear('created_at', $dateArray[0])
                ->paginate(10),
            'headers' => [
                ['key' => 'nanguIsp.name', 'label' => 'Poskytovalel', 'class' => 'text-white/80'],
                ['key' => 'created_at', 'label' => 'Vytvořeno', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
