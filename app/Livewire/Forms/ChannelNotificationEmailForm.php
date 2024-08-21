<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\IptvDohledUrlsNotification;

class ChannelNotificationEmailForm extends Form
{

    #[Validate('required', message: "Vyplňte email")]
    #[Validate('email', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    public string $email = "";

    public function create(object $iptvDohledUrl): void
    {
        $this->validate();
        IptvDohledUrlsNotification::create([
            'iptv_dohled_url_id' => $iptvDohledUrl->id,
            'email' => $this->email
        ]);
    }

    public function destroy(int $id): void
    {
        IptvDohledUrlsNotification::where('id', $id)->first()->delete();
    }
}
