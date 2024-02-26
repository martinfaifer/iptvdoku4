<?php

namespace App\Livewire\Forms;

use App\Models\ChannelMulticast;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateMulticastChannelForm extends Form
{
    public ?ChannelMulticast $multicast;

    public $stb_ip;
    public $source_ip;
    public $channel_source_id;
    public bool $is_backup = false;

    public function rules()
    {
        return [
            'stb_ip' => [
                'nullable', 'string', 'max:250',
                'unique:channel_multicasts,stb_ip,' . $this->multicast->id
            ],
            'source_ip' => [
                'nullable', 'string', 'max:250'
            ],
            'channel_source_id' => [
                'required', 'exists:channel_sources,id'
            ],
            'is_backup' => [
                'required', 'boolean'
            ]
        ];
    }

    public function messages()
    {
        return [
            'stb_ip.string' => "Neplatný formát",
            'stb_ip.max' => "Maximální počet znaků je :max",
            'stb_ip.unique' => "Tato IP již existuje",
            'source_ip.string' => "Napltný formát",
            'source.max' => "Maxilmální počet znaků je :max",
            'channel_source_id.required' => "Vyberte zdroj příjmu",
            'channel_source_id.exists' => "Zdroj neexistuje",
            'is_backup.required' => "Zvolte true / false",
            'is_backup.boolean' => "Neplatný formát"
        ];
    }

    public function setMulticast(ChannelMulticast $multicast)
    {
        $this->multicast = $multicast;
        $this->stb_ip = $multicast->stb_ip;
        $this->source_ip = $multicast->source_ip;
        $this->channel_source_id = $multicast->channel_source_id;
        $this->is_backup  = $multicast->is_backup;
    }

    public function update()
    {
        $this->validate();

        $this->multicast->update([
            'stb_ip' => $this->stb_ip,
            'source_ip' => $this->source_ip,
            'channel_source_id' => $this->channel_source_id,
            'is_backup' => ChannelMulticast
                ::where('channel_id', $this->multicast->channel_id)
                ->where('is_backup', false)
                ->first() ? true :  $this->is_backup
        ]);

        $this->reset('stb_ip', 'source_ip', 'channel_source_id', 'is_backup');
        $this->resetErrorBag();
    }
}
