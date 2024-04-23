<?php

namespace App\Livewire\Settings\Nangu\Isps;

use App\Livewire\Forms\CreateSettingsNanguIspForm;
use App\Livewire\Forms\UpdateSettingsNanguIspForm;
use App\Models\NanguIsp;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsIspComponent extends Component
{

    use WithPagination, NotificationTrait;

    public CreateSettingsNanguIspForm $createForm;

    public UpdateSettingsNanguIspForm $updateForm;

    public bool $createModal = false;

    public bool $editModal = false;

    public $query = '';

    public function openCreateModal()
    {
        $this->resetErrorBag();
        return $this->createModal = true;
    }

    public function openEditModal()
    {
        $this->resetErrorBag();
        return $this->editModal = true;
    }

    public function closeDialog()
    {
        $this->editModal = false;
        return $this->createModal = false;
    }

    public function create()
    {
        $this->createForm->create();

        $this->redirect(url()->previous(), true);

        return $this->success_alert("Poskytovatel vytvořen");
    }

    public function edit(NanguIsp $nanguIsp)
    {
        $this->updateForm->setNanguIsp($nanguIsp);
        return $this->openEditModal();
    }

    public function update()
    {
        $this->updateForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert("Poskytovatel upraven");
    }

    public function destroy(NanguIsp $nanguIsp)
    {
        $nanguIsp->delete();

        $this->redirect(url()->previous(), true);

        return $this->success_alert("Poskytovatel odebrán");
    }

    public function render()
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
