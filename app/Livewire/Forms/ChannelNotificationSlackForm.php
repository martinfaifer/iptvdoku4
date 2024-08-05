<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\IptvDohledUrlsNotification;

class ChannelNotificationSlackForm extends Form
{
    #[Validate('required', message: "Vyplňte email")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    public string $slack_channel = "";

    public function create(object $iptvDohledUrl)
    {
        $this->validate();
        IptvDohledUrlsNotification::create([
            'iptv_dohled_url_id' => $iptvDohledUrl->id,
            'slack_channel' => $this->slack_channel
        ]);
        $this->reset();
    }

    public function destroy($id)
    {
        IptvDohledUrlsNotification::where('id', $id)->first()->delete();
    }
}
