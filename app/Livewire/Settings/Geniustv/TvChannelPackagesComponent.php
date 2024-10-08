<?php

namespace App\Livewire\Settings\Geniustv;

use App\Livewire\Forms\CreateGeniusTvTvPackageForm;
use App\Livewire\Forms\UpdateGeniusTvTvPackageForm;
use App\Models\GeniusTvChannelPackage;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
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

    public function store(): void
    {
        $this->resetErrorBag();

        $this->createModal = true;
    }

    public function create(): mixed
    {
        $this->createForm->create();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Přidáno');
    }

    public function edit(GeniusTvChannelPackage $tvPackage): void
    {
        $this->updateForm->setTvPackage($tvPackage);

        $this->updateModal = true;
    }

    public function update(): mixed
    {
        $this->updateForm->update();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function destroy(GeniusTvChannelPackage $tvPackage): mixed
    {
        $tvPackage->delete();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function closeModal(): void
    {
        $this->createModal = false;
        $this->updateModal = false;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
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
