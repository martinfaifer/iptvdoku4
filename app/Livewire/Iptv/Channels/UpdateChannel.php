<?php

namespace App\Livewire\Iptv\Channels;

use App\Livewire\Forms\UpdateIptvChannel;
use App\Models\Channel;
use App\Models\ChannelCategory;
use App\Models\GeniusTvChannelPackage;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateChannel extends Component
{
    use NotificationTrait, WithFileUploads;

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
        $this->channelCategories = ChannelCategory::orderBy('name')->get(['id', 'name']);
        $this->geniusTVChannelPackages = GeniusTvChannelPackage::get();
        $this->channelsEpgs = ! Cache::has('channelEpgIds') ? [] : Cache::get('channelEpgIds');
    }

    public function update()
    {
        $this->form->update();

        if (! is_null($this->logo)) {
            $path = $this->logo->store(path: 'public/Logos');
            $this->channel->update([
                'logo' => $path,
            ]);
        }

        $this->closeDialog();
        // $this->dispatch('update_channels_sidebar');
        // $this->dispatch('update_iptv_channel.' . $this->channel->id);
        // $this->dispatch('update_iptv_channel_multicast.' . $this->channel->id, channelId: $this->channel->id);

        $this->redirect('/channels/'.$this->channel->id.'/multicast', true);

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
