<?php

namespace App\Livewire\Forms;

use App\Jobs\StoreStreamToIptvDohledJob;
use App\Models\Channel;
use App\Models\ChannelMulticast;
use Livewire\Form;

class StoreMulticastChannelForm extends Form
{
    public $stb_ip;

    public $source_ip;

    public $channel_source_id;

    public bool $is_backup = false;

    public bool $to_dohled = true;

    public $channel_id;

    public function rules()
    {
        return [
            'stb_ip' => [
                'nullable', 'string', 'max:250',
                'unique:channel_multicasts,stb_ip',
            ],
            'source_ip' => [
                'nullable', 'string', 'max:250',
            ],
            'channel_source_id' => [
                'required', 'exists:channel_sources,id',
            ],
            'is_backup' => [
                'required', 'boolean',
            ],
            'to_dohled' => [
                'required', 'boolean',
            ],
        ];
    }

    public function messages()
    {
        return [
            'stb_ip.string' => 'Neplatný formát',
            'stb_ip.max' => 'Maximální počet znaků je :max',
            'stb_ip.unique' => 'Tato IP již existuje',
            'source_ip.string' => 'Napltný formát',
            'source.max' => 'Maxilmální počet znaků je :max',
            'channel_source_id.required' => 'Vyberte zdroj příjmu',
            'channel_source_id.exists' => 'Zdroj neexistuje',
            'is_backup.required' => 'Zvolte true / false',
            'is_backup.boolean' => 'Neplatný formát',
            'to_dohled.required' => 'Zvolte true / false',
            'to_dohled.boolean' => 'Neplatný formát',
        ];
    }

    public function setChannel(Channel $channel)
    {
        $this->channel_id = $channel->id;
    }

    public function store()
    {
        $this->validate();

        ChannelMulticast::create([
            'channel_id' => $this->channel_id,
            'stb_ip' => $this->stb_ip,
            'source_ip' => $this->source_ip,
            'channel_source_id' => $this->channel_source_id,
            'is_backup' => ChannelMulticast::where('channel_id', $this->channel_id)
                ->where('is_backup', false)
                ->first() ? true : $this->is_backup,
        ]);

        if ($this->to_dohled == true) {
            if (!is_null($this->stb_ip)) {
                StoreStreamToIptvDohledJob::dispatch(
                    Channel::find($this->channel_id)->name . '_multicast',
                    $this->stb_ip
                );
            }
        }

        $this->closeForm();
    }

    public function closeForm()
    {
        $this->reset('stb_ip', 'source_ip', 'channel_source_id', 'is_backup', 'to_dohled');
        $this->resetErrorBag();
    }
}
