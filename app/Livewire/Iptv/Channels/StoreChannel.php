<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ChannelCategory;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Cache;
use App\Models\GeniusTvChannelPackage;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Channels\GetChannelsCategoriesFromCacheTrait;

class StoreChannel extends Component
{
    use NotificationTrait, WithFileUploads, GetChannelsCategoriesFromCacheTrait;

    #[Validate('required', message: 'Vyplňte název kanálu')]
    #[Validate('max:250', message: 'Maxilnálně 250 znaků')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('unique:channels,name', message: 'Kanál s tímto název již existuje')]
    public string $name = '';

    #[Validate('max:1024', message: 'Maximální velikost obrázku je 1Mb')]
    #[Validate('nullable')]
    public $logo;

    #[Validate('required', message: 'Vyberte kvalitu')]
    public $quality;

    #[Validate('required', message: 'Vyberte žánr')]
    #[Validate('exists:channel_categories,id', message: 'Neexistující žánr')]
    public $category;

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
    public $description;

    #[Validate('nullable')]
    public array $geniustvChannelPackage;

    #[Validate('nullable')]
    public ?string $epgId = null;

    public bool $storeModal = false;

    public $qualities = Channel::QUALITIES;

    public $geniusTVChannelPackages;

    public $channelCategories;

    public array $channelsEpgs;

    public function mount()
    {
        $this->channelCategories = $this->get_channels_categories_from_cache();
        $this->geniusTVChannelPackages = GeniusTvChannelPackage::get();
        $this->channelsEpgs = ! Cache::has('channelEpgIds') ? [] : Cache::get('channelEpgIds');
    }

    public function store()
    {
        $this->validate();

        if (! is_null($this->logo)) {
            $path = $this->logo->store(path: 'public/Logos');
        }

        $collectionQualities = collect(Channel::QUALITIES);
        $filteredQuality = $collectionQualities->where('id', $this->quality)->all();

        foreach ($filteredQuality as $q) {
            $qualityToChannel = $q['name'];
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
        ]);

        // $this->dispatch('update_channels_sidebar');
        // $this->closeDialog();

        $this->redirect('/channels/'.$channel->id.'/multicast', true);

        return $this->success_alert('Kanál přidán');
    }

    public function closeDialog()
    {
        $this->storeModal = false;
        $this->resetErrorBag();
        $this->reset(
            'name',
            'logo',
            'is_radio',
            'is_multiscreen',
            'quality',
            'category',
            'description',
            'nangu_chunk_store_id',
            'nangu_channel_code'
        );
    }

    public function render()
    {
        return view('livewire.iptv.channels.store-channel');
    }
}
