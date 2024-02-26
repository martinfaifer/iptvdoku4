<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Channel;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use App\Traits\Array\FindKeyByValueTrait;

class UpdateIptvChannel extends Form
{
    use FindKeyByValueTrait, WithFileUploads;

    public ?Channel $channel;
    public string $name = "";
    public $quality;
    public $category;
    public bool $is_radio;
    public bool $is_multiscreen;
    public $description;
    public $channelCategories;
    public $nangu_chunk_store_id;
    public $nangu_channel_code;

    public function rules()
    {
        return [
            'name' => ['required', 'max:250', 'string', 'unique:channels,name,' . $this->channel->id],
            'quality' => ["required"],
            'category' => ['required', 'exists:channel_categories,id'],
            'is_radio' => ["required", 'boolean'],
            'is_multiscreen' => ['required', 'boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
            'nangu_chunk_store_id' => ['nullable', 'max:250', 'string', 'unique:channels,nangu_chunk_store_id,' . $this->channel->id],
            'nangu_channel_code' => ['nullable', 'max:250', 'string', 'unique:channels,nangu_channel_code,' . $this->channel->id]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vyplňte název kanálu',
            'name.max' => "Maximální počet znaků je :max",
            'name.string' => "Neplatný formát",
            'name.unique' => "Kanál s tímto názvem již existuje",
            'quality.required' => "Vyberte kvalitu",
            'category.required' => "Vyberte kategorii",
            'category.exists' => "Neexistující kategorie",
            'is_radio.required' => "Musí být vybráno",
            'is_radio.boolean' => "Povoleno je pouze true / false",
            'is_multiscreen.required' => "Musí být vybráno",
            'is_mutliscreen.boolean' => "Povoleno je pouze true / false",
            'description.string' => "Neplatný formát",
            'description.max' => "Maximální počet znaků je :max",
            'nangu_chunk_store_id.max' => "Maximální počet znaků je :max",
            'nangu_chunk_store_id.string' => "Neplatný formát",
            'nangu_chunk_store_id.unique' => "Toto chunk store ID již existuje",
            'nangu_channel_code.max' => "Maximální počet znaků je :max",
            'nangu_channel_code.string' => "Neplatný formát",
            'nangu_channel_code.unique' => "Tento channel code již existuje",
        ];
    }

    public function setChannel(Channel $channel, $qualities)
    {
        $this->channel = $channel;
        $this->name = $channel?->name ?? "";
        $this->quality = $this->get_value_key($qualities, 'name', $channel->quality);
        $this->category = $channel->category;
        $this->is_radio = $channel->is_radio;
        $this->is_multiscreen = $channel->is_multiscreen;
        $this->description = $channel->description;
        $this->nangu_chunk_store_id = $channel->nangu_chunk_store_id;
        $this->nangu_channel_code = $channel->nangu_channel_code;
    }

    public function update()
    {
        $this->validate();

        $this->channel->update([
            'name' => $this->name,
            'is_radio' => $this->is_radio,
            'is_multiscreen' => $this->is_multiscreen,
            'quality' => Channel::QUALITIES[$this->quality]['name'],
            'category' => $this->category,
            'description' => $this->description,
            'nangu_chunk_store_id' => $this->nangu_chunk_store_id,
            'nangu_channel_code' => $this->nangu_channel_code
        ]);

        $this->reset('name', 'logo', 'quality', 'category', 'description', 'nangu_chunk_store_id', 'nangu_channel_code');
        $this->resetErrorBag();
    }
}
