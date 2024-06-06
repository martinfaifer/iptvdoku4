<?php

namespace App\Livewire\Forms;

use App\Jobs\DeleteStreamFromIptvDohledJob;
use App\Jobs\StoreStreamToIptvDohledJob;
use App\Models\ChannelQualityWithIp;
use App\Traits\Channels\CheckIfChannelIsInIptvDohledTrait;
use Livewire\Form;

class UpdateH264ChannelForm extends Form
{
    use CheckIfChannelIsInIptvDohledTrait;

    public ?ChannelQualityWithIp $channelQualityWithIp;

    public $ip = '';

    public bool $isInDohled = false;

    public bool $to_dohled = false;

    public bool $delete_from_dohled = false;

    public function rules()
    {
        return [
            'ip' => [
                'required', 'unique:channel_quality_with_ips,ip,'.$this->channelQualityWithIp->id,
            ],
        ];
    }

    public function messeges()
    {
        return [
            'ip.required' => 'Vyplňte IP',
            'ip.unique' => 'Již existuje u jiného kanálu',
        ];
    }

    public function setUnicast(ChannelQualityWithIp $channelQualityWithIp)
    {
        $this->channelQualityWithIp = $channelQualityWithIp;
        $this->ip = $channelQualityWithIp->ip;
        $this->isInDohled = $this->isInIptvDohledDohled($channelQualityWithIp->ip);
    }

    public function update()
    {
        $this->validate();
        $this->channelQualityWithIp->update([
            'ip' => $this->ip,
        ]);

        if ($this->to_dohled == true) {
            StoreStreamToIptvDohledJob::dispatch(
                $this->channelQualityWithIp->h264->channel->name.'_h264',
                $this->ip
            );
        }

        if ($this->delete_from_dohled == true) {
            DeleteStreamFromIptvDohledJob::dispatch(
                $this->ip
            );
        }
        $this->reset();
    }
}
