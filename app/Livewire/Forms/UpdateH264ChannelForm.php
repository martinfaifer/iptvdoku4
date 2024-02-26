<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\ChannelQualityWithIp;

class UpdateH264ChannelForm extends Form
{
    public ?ChannelQualityWithIp $channelQualityWithIp;

    public $ip = "";

    public function rules()
    {
        return [
            'ip' => [
                'required', 'unique:channel_quality_with_ips,ip,' . $this->channelQualityWithIp->id
            ]
        ];
    }

    public function messeges()
    {
        return [
            'ip.required' => "Vyplňte IP",
            'ip.unique' => "Již existuje u jiného kanálu"
        ];
    }

    public function setUnicast(ChannelQualityWithIp $channelQualityWithIp)
    {
        $this->channelQualityWithIp = $channelQualityWithIp;
        $this->ip = $channelQualityWithIp->ip;
    }

    public function update()
    {
        $this->validate();
        $this->channelQualityWithIp->update([
            'ip' => $this->ip
        ]);
        $this->reset();
    }
}
