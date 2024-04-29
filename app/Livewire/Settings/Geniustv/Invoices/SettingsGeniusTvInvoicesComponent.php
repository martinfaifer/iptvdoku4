<?php

namespace App\Livewire\Settings\GeniusTv\Invoices;

use App\Models\NanguIspInvoice;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsGeniusTvInvoicesComponent extends Component
{
    use WithPagination;

    public string $selectedDate;

    public string $query = '';

    public string $selectedInvoiceMonth;

    public string $selectedInvoiceYear;

    public array $availableInvoiceDates;

    public function mount()
    {
        $this->selectedInvoiceMonth = now()->month;
        $this->selectedInvoiceYear = now()->year;
        if ($this->selectedInvoiceMonth < 10) {
            $this->selectedDate = $this->selectedInvoiceYear.'-0'.$this->selectedInvoiceMonth;
        } else {
            $this->selectedDate = $this->selectedInvoiceYear.'-'.$this->selectedInvoiceMonth;
        }
    }

    public function render()
    {
        $dateArray = explode('-', $this->selectedDate);

        return view('livewire.settings.genius-tv.invoices.settings-genius-tv-invoices-component', [
            'invoicesForSelectedDate' => NanguIspInvoice::search($this->query)
                ->with('nanguIsp')
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
