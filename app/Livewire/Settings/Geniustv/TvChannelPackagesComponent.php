<?php

namespace App\Livewire\Settings\Geniustv;

use App\Livewire\Forms\CreateGeniusTvTvPackageForm;
use App\Livewire\Forms\UpdateGeniusTvTvPackageForm;
use App\Models\GeniusTvChannelPackage;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;
use Livewire\WithPagination;

class TvChannelPackagesComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateGeniusTvTvPackageForm $createForm;

    public UpdateGeniusTvTvPackageForm $updateForm;

    public string $query = '';

    public bool $createModal = false;

    public bool $updateModal = false;

    public function store()
    {
        $this->resetErrorBag();

        return $this->createModal = true;
    }

    public function create()
    {
        $this->createForm->create();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Přidáno');
    }

    public function edit(GeniusTvChannelPackage $tvPackage)
    {
        $this->updateForm->setTvPackage($tvPackage);

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->updateForm->update();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function destroy(GeniusTvChannelPackage $tvPackage)
    {
        $tvPackage->delete();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function closeModal()
    {
        $this->createModal = false;
        $this->updateModal = false;
    }

    public function render()
    {
        return view('livewire.settings.geniustv.tv-channel-packages-component', [
            'tvPackages' => GeniusTvChannelPackage::search($this->query)->paginate(),
            'headers' => [
                ['key' => 'name', 'label' => 'Balíček', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
