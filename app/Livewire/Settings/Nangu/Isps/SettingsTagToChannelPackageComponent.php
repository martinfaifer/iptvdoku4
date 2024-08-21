<?php

namespace App\Livewire\Settings\Nangu\Isps;

use App\Models\Tag;
use Livewire\Component;
use App\Models\NanguIsp;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;
use App\Models\NanguIspTagToChannelPackage;
use App\Livewire\Forms\CreateSettingsTagToChannelPackageForm;
use App\Livewire\Forms\UpdateSettingsTagToChannelPackageForm;

class SettingsTagToChannelPackageComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsTagToChannelPackageForm $createForm;

    public UpdateSettingsTagToChannelPackageForm $updateForm;

    public bool $createModal = false;

    public bool $editModal = false;

    public Collection $nanguIsps;

    public Collection $tags;

    public function mount(): void
    {
        $this->nanguIsps = NanguIsp::get(['id', 'name']);
        $this->tags = Tag::get();
    }

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

    public function edit(NanguIspTagToChannelPackage $nanguIspTagToChannelPackage): void
    {
        $this->updateForm->setNanguIspTagToChannelPackage($nanguIspTagToChannelPackage);

        $this->openEditModal();
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function create(): mixed
    {
        $this->createForm->create();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Vazba přidána');
    }

    public function destroy(NanguIspTagToChannelPackage $nanguIspTagToChannelPackage): mixed
    {
        $nanguIspTagToChannelPackage->delete();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
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
