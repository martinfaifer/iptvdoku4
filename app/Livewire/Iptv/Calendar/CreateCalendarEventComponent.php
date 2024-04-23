<?php

namespace App\Livewire\Iptv\Calendar;

use App\Models\Tag;
use App\Models\User;
use App\Models\Channel;
use Livewire\Component;
use App\Models\CssColor;
use App\Models\NanguIsp;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use App\Traits\Livewire\NotificationTrait;
use App\Models\NanguIspTagToChannelPackage;
use App\Livewire\Forms\CreateCalendarEventForm;
use App\Models\SftpServer;

class CreateCalendarEventComponent extends Component
{
    use NotificationTrait, WithFileUploads;

    public CreateCalendarEventForm $form;

    public bool $storeModal = false;

    public Collection $users;

    public Collection $cssColors;

    public Collection $channels;

    public Collection $sftpServers;

    public array $tags;

    public function mount()
    {
        $this->cssColors = CssColor::get();
        $this->users = User::get();
        $this->channels = Channel::orderBy('name', "ASC")->get(['id', 'name']);
        $this->sftpServers = SftpServer::get(['id', 'name']);
        if (NanguIspTagToChannelPackage::first()) {
            foreach (NanguIspTagToChannelPackage::distinct()->get('tag_id') as $nanguIspTagToChannelPackage) {

                $this->tags[] = [
                    'id' => $nanguIspTagToChannelPackage->tag_id,
                    'name' => Tag::find($nanguIspTagToChannelPackage->tag_id)->name
                ];
            }
        }
    }

    public function create()
    {
        $this->form->create();
        $this->redirect('/calendar', true);
        $this->closeModal();
        return $this->success_alert("Přidáno");
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
