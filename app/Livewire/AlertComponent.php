<?php

namespace App\Livewire;

use App\Models\Alert;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class AlertComponent extends Component
{
    public bool $showAlert = false;

    public bool $showAlerts = false;

    public bool $isStacked = true;

    public int $numberOfAlerts = 0;

    public Collection $alerts;

    public function mount()
    {
        $this->check_alerts();
    }

    #[On('echo:refresh-alerts,BroadcastAlertEvent')]
    public function check_alerts()
    {
        $this->numberOfAlerts = Alert::where('type', 'gpu_problem')->count();

        if ($this->numberOfAlerts == 0) {
            $this->showAlert = false;
            $this->showAlerts = false;
        }

        if ($this->numberOfAlerts == 1) {
            $this->showAlert = true;
            $this->showAlerts = false;
        }

        if ($this->numberOfAlerts > 1) {
            $this->showAlert = false;
            $this->showAlerts = true;
        }

        $this->alerts = Alert::where('type', 'gpu_problem')->get();
    }

    public function changeStack()
    {
        return $this->isStacked = ! $this->isStacked;
    }

    public function render()
    {
        return view('livewire.alert-component');
    }
}
