<?php

namespace App\Livewire\Settings\Nangu\Isps;

use App\Livewire\Forms\CreateSettingsTagToChannelPackageForm;
use App\Livewire\Forms\UpdateSettingsTagToChannelPackageForm;
use App\Models\NanguIsp;
use App\Models\NanguIspTagToChannelPackage;
use App\Models\Tag;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsTagToChannelPackageComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsTagToChannelPackageForm $createForm;

    public UpdateSettingsTagToChannelPackageForm $updateForm;

    public bool $createModal = false;

    public bool $editModal = false;

    public Collection $nanguIsps;

    public Collection $tags;

    public function mount()
    {
        $this->nanguIsps = NanguIsp::get(['id', 'name']);
        $this->tags = Tag::get();
    }

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

    public function edit(NanguIspTagToChannelPackage $nanguIspTagToChannelPackage)
    {
        $this->updateForm->setNanguIspTagToChannelPackage($nanguIspTagToChannelPackage);

        return $this->openEditModal();
    }

    public function update()
    {
        $this->updateForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function create()
    {
        $this->createForm->create();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Vazba přidána');
    }

    public function destroy(NanguIspTagToChannelPackage $nanguIspTagToChannelPackage)
    {
        $nanguIspTagToChannelPackage->delete();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function render()
    {
        return view('livewire.settings.nangu.isps.settings-tag-to-channel-package-component', [
            'nanguIspTagToChannelPackages' => NanguIspTagToChannelPackage::with(['nangu_isp', 'tag'])->orderBy('nangu_isp_id', 'ASC')->paginate(5),
            'headers' => [
                ['key' => 'nangu_isp.name', 'label' => 'Poskytovatel', 'class' => 'text-white/80'],
                ['key' => 'tag.name', 'label' => 'Štítek', 'class' => 'text-white/80'],
                ['key' => 'nangu_channel_package_name', 'label' => 'Balíček', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
