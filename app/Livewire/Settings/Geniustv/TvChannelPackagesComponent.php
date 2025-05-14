<?php

namespace App\Livewire\Settings\Geniustv;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GeniusTvChannelPackage;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Channels\GetChannelPackagesTrait;
use App\Livewire\Forms\CreateGeniusTvTvPackageForm;
use App\Livewire\Forms\UpdateGeniusTvTvPackageForm;

class TvChannelPackagesComponent extends Component
{
    use NotificationTrait, WithPagination, GetChannelPackagesTrait;

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
        $this->removeChannelPackagesFromCache();
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
                ['key' => 'name', 'label' => 'Balíček', 'class' => 'dark:text-white/80'],
                ['key' => 'is_optional', 'label' => 'Příplatkový balíček', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
