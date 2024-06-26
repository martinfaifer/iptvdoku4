<?php

namespace App\Livewire\Iptv\Calendar;

use App\Actions\CssColors\GetCssColorsFromCacheAction;
use App\Livewire\Forms\CreateCalendarEventForm;
use App\Models\NanguIspTagToChannelPackage;
use App\Models\Tag;
use App\Traits\Channels\GetChannelFromCacheTrait;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Sftps\GetSftpServersFromCache;
use App\Traits\Users\GetUsersFromCacheTrait;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateCalendarEventComponent extends Component
{
    use GetChannelFromCacheTrait,
        GetSftpServersFromCache,
        GetUsersFromCacheTrait,
        NotificationTrait,
        WithFileUploads;

    public CreateCalendarEventForm $form;

    public bool $storeModal = false;

    public Collection $users;

    public Collection $cssColors;

    public Collection $channels;

    public Collection $sftpServers;

    public array $tags;

    public function mount()
    {
        $this->cssColors = (new GetCssColorsFromCacheAction())();
        $this->users = $this->get_users_from_cache();
        $this->channels = $this->get_channels_from_cache();
        $this->sftpServers = $this->get_sftp_servers_from_cache();
        if (NanguIspTagToChannelPackage::first()) {
            foreach (NanguIspTagToChannelPackage::distinct()->get('tag_id') as $nanguIspTagToChannelPackage) {
                $this->tags[] = [
                    'id' => $nanguIspTagToChannelPackage->tag_id,
                    'name' => Tag::find($nanguIspTagToChannelPackage->tag_id)->name,
                ];
            }
        }
    }

    public function create()
    {
        $this->form->create();
        $this->redirect(url()->previous(), true);
        $this->closeModal();

        return $this->success_alert('Přidáno');
    }

    public function openModal()
    {
        return $this->storeModal = true;
    }

    public function closeModal()
    {
        $this->form->reset();

        return $this->storeModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.calendar.create-calendar-event-component');
    }
}
