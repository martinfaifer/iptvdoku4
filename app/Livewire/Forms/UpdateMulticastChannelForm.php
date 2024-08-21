<?php

namespace App\Livewire\Forms;

use App\Jobs\DeleteStreamFromIptvDohledJob;
use App\Jobs\StoreStreamToIptvDohledJob;
use App\Jobs\UpdateStreamUrlInDohledIfIsItJob;
use App\Models\Channel;
use App\Models\ChannelMulticast;
use App\Traits\Channels\CheckIfChannelIsInIptvDohledTrait;
use Livewire\Form;

class UpdateMulticastChannelForm extends Form
{
    use CheckIfChannelIsInIptvDohledTrait;

    public ?ChannelMulticast $multicast;

    public string $stb_ip = "";

    public string $source_ip = "";

    public int $channel_source_id;

    public bool $is_backup = false;

    public bool $isInDohled = false;

    public bool $to_dohled = false;

    public bool $delete_from_dohled = false;

    public function rules(): array
    {
        return [
            'stb_ip' => [
                'nullable',
                'string',
                'max:250',
                'unique:channel_multicasts,stb_ip,' . $this->multicast->id,
            ],
            'source_ip' => [
                'nullable',
                'string',
                'max:250',
            ],
            'channel_source_id' => [
                'required',
                'exists:channel_sources,id',
            ],
            'is_backup' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function messages(): array
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
        ];
    }

    public function setMulticast(ChannelMulticast $multicast): void
    {
        $this->multicast = $multicast;
        $this->stb_ip = $multicast->stb_ip;
        $this->source_ip = $multicast->source_ip;
        $this->channel_source_id = $multicast->channel_source_id;
        $this->is_backup = $multicast->is_backup;
        $this->isInDohled = $this->isInIptvDohledDohled($multicast->stb_ip);
    }

    public function update(): void
    {
        $this->validate();

        if ($this->stb_ip != $this->multicast->stb_ip) {
            // fire check if in dohled and update record in dohled
            UpdateStreamUrlInDohledIfIsItJob::dispatch(
                $this->stb_ip,
                $this->multicast->stb_ip,
                Channel::find($this->multicast->channel_id)->name . '_multicast'
            );
        }

        // un necessary to send to iptv dohled
        // if ($this->source_ip != $this->multicast->source_ip) {
        //     // fire check if in dohled and update record in dohled
        //     UpdateStreamUrlInDohledIfIsItJob::dispatch(
        //         $this->source_ip,
        //         $this->multicast->source_ip,
        //         Channel::find($this->multicast->channel_id)->name.'_multicast'
        //     );
        // }

        $this->multicast->update([
            'stb_ip' => $this->stb_ip,
            'source_ip' => $this->source_ip,
            'channel_source_id' => $this->channel_source_id,
            'is_backup' => $this->is_backup,
        ]);

        if ($this->to_dohled == true) {
            StoreStreamToIptvDohledJob::dispatch(
                Channel::find($this->multicast->channel_id)->name . '_multicast',
                $this->stb_ip
            );
        }

        if ($this->delete_from_dohled == true) {
            DeleteStreamFromIptvDohledJob::dispatch(
                $this->stb_ip
            );
        }

        $this->reset('stb_ip', 'source_ip', 'channel_source_id', 'is_backup');
        $this->resetErrorBag();
    }
}
