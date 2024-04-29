<?php

namespace App\Livewire\Settings\Geniustv\StaticTaxes;

use App\Livewire\Forms\CreateSettingsGeniusTvStaticTaxesForm;
use App\Livewire\Forms\UpdateSettingsGeniusTvStaticTaxesForm;
use App\Models\Currency;
use App\Models\GeniusTVStaticTax;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsGeniusTvStaticTaxesComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateSettingsGeniusTvStaticTaxesForm $form;

    public UpdateSettingsGeniusTvStaticTaxesForm $updateForm;

    public $query = '';

    public bool $createModal = false;

    public bool $updateModal = false;

    public Collection $currencies;

    public function mount()
    {
        $this->currencies = Currency::get();
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

        $this->dispatch('refresh_settings_genius_tv_static_taxes');

        return $this->success_alert('Přidáno');
    }

    public function edit(GeniusTVStaticTax $staticTax)
    {
        $this->resetErrorBag();

        $this->updateForm->setStaticTax($staticTax);

        return $this->updateModal = true;
    }

    public function update()
    {
        $this->updateForm->update();

        $this->closeDialog();

        $this->dispatch('refresh_settings_genius_tv_static_taxes');

        return $this->success_alert('Upraveno');
    }

    public function destroy(GeniusTVStaticTax $staticTax)
    {

        $staticTax->delete();

        $this->dispatch('refresh_settings_genius_tv_static_taxes');

        $this->success_alert('Odebráno');
    }

    #[On('refresh_settings_genius_tv_static_taxes')]
    public function render()
    {
        return view('livewire.settings.geniustv.static-taxes.settings-genius-tv-static-taxes-component', [
            'staticTaxes' => GeniusTVStaticTax::orderBy('name')->with('currency_name')->search($this->query)->paginate(5),
            'headers' => [
                ['key' => 'name', 'label' => 'Poplatek', 'class' => 'text-white/80'],
                ['key' => 'price', 'label' => 'Cena', 'class' => 'text-white/80'],
                ['key' => 'currency_name.name', 'label' => 'Měna', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
        ]);
    }
}
