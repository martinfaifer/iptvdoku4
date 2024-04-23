<?php

namespace App\Livewire\Forms;

use App\Models\ChannelQualityWithIp;
use App\Models\RestartChannel;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsChannelsRestartForm extends Form
{
    #[Validate('required', message: "Vyberte kanál")]
    #[Validate('exists:channels,id', message: "Neexistující kanál")]
    public string|int|null $channelId = null;

    #[Validate('required', message: "Vyplňte url streamu")]
    #[Validate('unique:restart_channels,ip_id', message: "Tato url již existuje")]
    #[Validate('string', message: "Neplatný formát")]
    public string $ip = "";

    #[Validate('required', message: "Vyberte zařízení")]
    #[Validate('exists:devices,id', message: "Neexistující zařízení")]
    public string|int|null $deviceId = null;

    public function create(): void
    {
        $this->validate();

        RestartChannel::create([
            'channel_id' => $this->channelId,
            'ip_id' => $this->ip,
            'device_id' => $this->deviceId
        ]);

        $this->reset();
    }
}
