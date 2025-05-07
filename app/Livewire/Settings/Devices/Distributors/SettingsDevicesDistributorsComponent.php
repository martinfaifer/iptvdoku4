<?php

namespace App\Livewire\Settings\Devices\Distributors;

use App\Livewire\Forms\CreateSettingsDevicesDistributorsForm;
use App\Livewire\Forms\UpdateSettingsDevicesDistributorsForm;
use App\Models\SatelitCardVendor;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsDevicesDistributorsComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsDevicesDistributorsForm $createForm;

    public UpdateSettingsDevicesDistributorsForm $updateForm;

    public string $query = '';

    public bool $createModal = false;

    public bool $editModal = false;

    public function openCreateModal(): void
    {
        $this->createModal = true;
    }

    public function closeDialog(): void
    {
        $this->createForm->reset();
        $this->updateForm->reset();
        $this->createModal = false;
        $this->editModal = false;
    }

    public function create(): mixed
    {
        $this->createForm->create();
        $this->redirect(url()->previous(), true);

        return $this->success_alert('Přidáno');
    }

    public function edit(SatelitCardVendor $satelitCardVendor): void
    {
        $this->updateForm->setDistributor($satelitCardVendor);

        $this->editModal = true;
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function destroy(SatelitCardVendor $satelitCardVendor): mixed
    {
        try {
            $satelitCardVendor->delete();

            $this->redirect(url()->previous(), true);

            return $this->success_alert('Odebráno');
        } catch (\Throwable $th) {
            $this->redirect(url()->previous(), true);

            return $this->error_alert('Existuje vazba na satelitní kartu');
        }
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.devices.distributors.settings-devices-distributors-component', [
            'headers' => [
                ['key' => 'name', 'label' => 'Distributor', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
            'distributors' => SatelitCardVendor::search($this->query)->paginate(5),
        ]);
    }
}
