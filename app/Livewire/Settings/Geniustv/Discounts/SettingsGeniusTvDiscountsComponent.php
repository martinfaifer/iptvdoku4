<?php

namespace App\Livewire\Settings\Geniustv\Discounts;

use Livewire\Component;
use App\Models\NanguIsp;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\GeniusTvDiscount;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Forms\CreateSettingsGeniusTvDiscountsForm;
use App\Livewire\Forms\UpdateSettingsGeniusTvDiscountsForm;

class SettingsGeniusTvDiscountsComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsGeniusTvDiscountsForm $form;

    public UpdateSettingsGeniusTvDiscountsForm $updateForm;

    public bool $createModal = false;

    public bool $updateModal = false;

    public Collection $nanguIsps;

    public function mount()
    {
        $this->nanguIsps = NanguIsp::get(['id', 'name']);
    }

    public function openCreateModal()
    {
        $this->resetErrorBag();
        return $this->createModal = true;
    }

    public function closeDialog()
    {
        $this->updateModal = false;
        return $this->createModal = false;
    }

    public function create()
    {
        $this->form->create();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_discoints');

        $this->success_alert("Vytvořeno");
    }

    public function edit(GeniusTvDiscount $geniusTvDiscount)
    {
        $this->resetErrorBag();

        $this->updateForm->setGeniusTvDiscount($geniusTvDiscount);

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_discoints');

        return $this->success_alert("Upraveno");
    }

    public function destroy(GeniusTvDiscount $geniusTvDiscount)
    {
        $geniusTvDiscount->delete();

        $this->dispatch('refresh_settings_genius_tv_discoints');
    }

    #[On('refresh_settings_genius_tv_discoints')]

    public function render()
    {
        return view('livewire.settings.geniustv.discounts.settings-genius-tv-discounts-component', [
            'discounts' => GeniusTvDiscount
                ::with('nanguIsp')
                // ->search($this->query)
                ->paginate(5),
            'headers' => [
                ['key' => 'nanguIsp.name', 'label' => 'Poskytoval', 'class' => 'text-white/80'],
                ['key' => 'discount', 'label' => 'Sleva', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
