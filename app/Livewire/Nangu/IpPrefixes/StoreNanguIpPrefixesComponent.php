<?php

namespace App\Livewire\Nangu\IpPrefixes;

use App\Livewire\Forms\StoreNanguIpPrefixForm;
use App\Models\NanguIsp;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Prefixes\CidrTrait;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class StoreNanguIpPrefixesComponent extends Component
{
    use CidrTrait, NotificationTrait;

    public StoreNanguIpPrefixForm $form;

    public bool $storeModal = false;

    public Collection $nanguIsps;

    public array $cidr = [];

    public function mount()
    {
        $this->nanguIsps = NanguIsp::get(['id', 'name']);
        $this->cidr = $this->available_cidrs();
    }

    public function openModal()
    {
        $this->storeModal = true;
    }

    public function closeDialog()
    {
        $this->resetErrorBag();

        return $this->storeModal = false;
    }

    public function store()
    {
        $stored = $this->form->create();

        $this->redirect('/prefixes/'.$stored->id, true);

        return $this->success_alert('Prefix přidán');
    }

    public function render()
    {
        return view('livewire.nangu.ip-prefixes.store-nangu-ip-prefixes-component');
    }
}
