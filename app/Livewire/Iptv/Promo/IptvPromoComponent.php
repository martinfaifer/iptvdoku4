<?php

namespace App\Livewire\Iptv\Promo;

use Livewire\Component;
use App\Models\IptvPromo;
use Livewire\WithPagination;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateIptvPromoUserForm;

class IptvPromoComponent extends Component
{
    use NotificationTrait, WithPagination;

    public CreateIptvPromoUserForm $form;

    public bool $createModal = false;

    public function create(): void
    {
        $this->form->submit() === false
            ? $this->error_alert(text: "Nepodařilo se vytvořit promo")
            : $this->success_alert("Promo vytvořeno");

        $this->closeDialog();
    }

    public function openCreateModal(): void
    {
        $this->form->setNextExpirationDate();
        $this->createModal = true;
    }

    public function closeDialog(): void
    {
        $this->createModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.promo.iptv-promo-component', [
            'customers' => IptvPromo::paginate(),
            'headers' => [
                ['key' => 'customer', 'label' => 'Zákazník'],
                ['key' => 'locality', 'label' => 'Bydliště', 'class' => 'dark:text-white/80'],
                ['key' => 'contact', 'label' => 'Kontakt', 'class' => 'dark:text-white/80'],
                ['key' => 'creator', 'label' => 'Kdo založil', 'class' => 'dark:text-white/80'],
                ['key' => 'expiration', 'label' => 'Expirace', 'class' => 'dark:text-white/80'],
                ['key' => 'login', 'label' => 'Přístup', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ])->title(config('app.name') . '- Promo');
    }
}
