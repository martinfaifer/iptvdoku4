<?php

namespace App\Livewire\Settings\Geniustv\Discounts;

use App\Livewire\Forms\CreateSettingsGeniusTvDiscountsForm;
use App\Livewire\Forms\UpdateSettingsGeniusTvDiscountsForm;
use App\Models\GeniusTvDiscount;
use App\Models\NanguIsp;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsGeniusTvDiscountsComponent extends Component
{
    use NotificationTrait, WithPagination;

    public string $query = '';

    public CreateSettingsGeniusTvDiscountsForm $form;

    public UpdateSettingsGeniusTvDiscountsForm $updateForm;

    public bool $createModal = false;

    public bool $updateModal = false;

    public Collection $nanguIsps;

    public function mount(): void
    {
        $this->nanguIsps = NanguIsp::get(['id', 'name']);
    }

    public function openCreateModal(): void
    {
        $this->resetErrorBag();

        $this->createModal = true;
    }

    public function closeDialog(): void
    {
        $this->updateModal = false;

        $this->createModal = false;
    }

    public function create(): mixed
    {
        $this->form->create();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_discoints');

        return $this->success_alert('Vytvořeno');
    }

    public function edit(GeniusTvDiscount $geniusTvDiscount): void
    {
        $this->resetErrorBag();

        $this->updateForm->setGeniusTvDiscount($geniusTvDiscount);

        $this->updateModal = true;
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_discoints');

        return $this->success_alert('Upraveno');
    }

    public function destroy(GeniusTvDiscount $geniusTvDiscount): void
    {
        $geniusTvDiscount->delete();

        $this->dispatch('refresh_settings_genius_tv_discoints');
    }

    #[On('refresh_settings_genius_tv_discoints')]
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.geniustv.discounts.settings-genius-tv-discounts-component', [
            'discounts' => GeniusTvDiscount::with('nanguIsp')
                ->search($this->query)
                ->paginate(5),
            'headers' => [
                ['key' => 'nanguIsp.name', 'label' => 'Poskytoval', 'class' => 'dark:text-white/80'],
                ['key' => 'discount', 'label' => 'Sleva', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
