<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Channel;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ChannelCategory;
use Illuminate\Support\Facades\Cache;
use App\Models\GeniusTvChannelPackage;
use App\Livewire\Forms\UpdateIptvChannel;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Channels\GetChannelsCategoriesFromCacheTrait;

class UpdateChannel extends Component
{
    use NotificationTrait, WithFileUploads, GetChannelsCategoriesFromCacheTrait;

    public UpdateIptvChannel $form;

    public ?Channel $channel;

    public $channelType;

    public $logo;

    public bool $updateModal = false;

    public $qualities = Channel::QUALITIES;

    public $channelCategories;

    public $geniusTVChannelPackages;

    public array $channelsEpgs;

    public function mount($channelType = null)
    {
        $this->channelCategories = $this->get_channels_categories_from_cache();
        $this->geniusTVChannelPackages = GeniusTvChannelPackage::get();
        $this->channelsEpgs = !Cache::has('channelEpgIds') ? [] : Cache::get('channelEpgIds');
    }

    public function update()
    {
        $this->form->update();

        if (!is_null($this->logo)) {
            $path = $this->logo->store(path: 'public/Logos');
            $this->channel->update([
                'logo' => $path,
            ]);
        }

        $this->closeDialog();
        // $this->dispatch('update_channels_sidebar');
        // $this->dispatch('update_iptv_channel');
        // $this->dispatch('update_multicast.' . $this->channel->id, channelId: $this->channel->id);

        $this->redirect('/channels/' . $this->channel->id . '/multicast', true);

        return $this->success_alert('Upraveno');
    }

    public function closeDialog()
    {
        $this->updateModal = false;
    }

    public function edit()
    {
        $this->form->setChannel($this->channel, $this->qualities);
        $this->updateModal = true;
    }

    public function render()
    {
        return view('livewire.iptv.channels.update-channel');
    }
}
