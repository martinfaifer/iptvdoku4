<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Channel;
use Livewire\Attributes\Validate;

class StoreChannelForm extends Form
{
    #[Validate('required', message: 'Vyplňte název kanálu')]
    #[Validate('max:250', message: 'Maxilnálně 250 znaků')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('unique:channels,name', message: 'Kanál s tímto název již existuje')]
    public string $name = '';

    #[Validate('max:1024', message: 'Maximální velikost obrázku je 1Mb')]
    #[Validate('nullable')]
    public mixed $logo = null;

    #[Validate('required', message: 'Vyberte kvalitu')]
    public mixed $quality = null;

    #[Validate('required', message: 'Vyberte žánr')]
    #[Validate('exists:channel_categories,id', message: 'Neexistující žánr')]
    public mixed $category = null;

    #[Validate('boolean', message: 'Neplatný formát')]
    public bool $is_radio = false;

    #[Validate('boolean', message: 'Neplatný formát')]
    public bool $is_multiscreen = true;

    #[Validate('nullable')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('unique:channels,nangu_chunk_store_id', message: 'Tento chunkStoreId již existuje')]
    public ?string $nangu_chunk_store_id = null;

    #[Validate('required', message: 'Vyplňte nangu channel code')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('unique:channels,nangu_channel_code', message: 'Tento nanguChannelCode již existuje')]
    public ?string $nangu_channel_code = null;

    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('nullable')]
    public mixed $description = "";

    #[Validate('nullable')]
    public array $geniustvChannelPackage = [];

    #[Validate('nullable')]
    public ?string $epgId = null;

    #[Validate('required', message: "Vyberete území, kde se kanál vysílá")]
    #[Validate('exists:channel_regions,id', message: "Neexistující region")]
    public int $selectedRegion = 3;

    #[Validate('nullable')]
    public ?string $programer = null;

    public function submit(): int
    {
        $this->validate();

        $qualityToChannel = '';
        if (! is_null($this->logo)) {
            $path = $this->logo->store(path: 'public/Logos');
        }

        $collectionQualities = collect(Channel::QUALITIES);
        $filteredQuality = $collectionQualities->where('id', $this->quality)->all();

        foreach ($filteredQuality as $quality) {
            $qualityToChannel = $quality['name'];
        }

        $channel = Channel::create([
            'name' => $this->name,
            'logo' => isset($path) ? $path : null,
            'is_radio' => $this->is_radio,
            'is_multiscreen' => $this->is_multiscreen,
            'quality' => $qualityToChannel,
            'category' => $this->category,
            'description' => $this->description,
            'nangu_chunk_store_id' => trim($this->nangu_chunk_store_id),
            'nangu_channel_code' => trim($this->nangu_channel_code),
            'geniustv_channel_packages_id' => json_encode($this->geniustvChannelPackage),
            'epg_id' => $this->epgId,
            'channel_region_id' => $this->selectedRegion,
            'channel_programmer_id' => $this->programer
        ]);

        $this->reset();

        return $channel->id;
    }
}
