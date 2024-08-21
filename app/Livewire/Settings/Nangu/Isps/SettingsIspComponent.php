<?php

namespace App\Livewire\Settings\Nangu\Isps;

use App\Livewire\Forms\CreateSettingsNanguIspForm;
use App\Livewire\Forms\UpdateSettingsNanguIspForm;
use App\Models\Ip;
use App\Models\NanguIsp;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsIspComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsNanguIspForm $createForm;

    public UpdateSettingsNanguIspForm $updateForm;

    public bool $createModal = false;

    public bool $editModal = false;

    public string $query = '';

    public function openCreateModal(): void
    {
        $this->resetErrorBag();

        $this->createModal = true;
    }

    public function openEditModal(): void
    {
        $this->resetErrorBag();

        $this->editModal = true;
    }

    public function closeDialog(): void
    {
        $this->editModal = false;

        $this->createModal = false;
    }

    public function create(): mixed
    {
        $this->createForm->create();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Poskytovatel vytvořen');
    }

    public function edit(NanguIsp $nanguIsp): void
    {
        $this->updateForm->setNanguIsp($nanguIsp);

        $this->openEditModal();
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Poskytovatel upraven');
    }

    public function destroy(NanguIsp $nanguIsp): mixed
    {
        try {
            Ip::where('nangu_isp_id', $nanguIsp->id)->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        $nanguIsp->delete();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Poskytovatel odebrán');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.nangu.isps.settings-isp-component', [
            'nanguIsps' => NanguIsp::search($this->query)->paginate(5),
            'headers' => [
                ['key' => 'name', 'label' => 'Název', 'class' => 'text-white/80'],
                ['key' => 'nangu_isp_id', 'label' => 'Nangu ID', 'class' => 'text-white/80'],
                ['key' => 'is_akcionar', 'label' => 'Akcionář', 'class' => 'text-white/80'],
                ['key' => 'ic', 'label' => 'IČ', 'class' => 'text-white/80'],
                ['key' => 'dic', 'label' => 'DIČ', 'class' => 'text-white/80'],
                ['key' => 'hbo_key', 'label' => 'HBO', 'class' => 'text-white/80'],
                ['key' => 'crm_contract_id', 'label' => 'CRM contract id', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
