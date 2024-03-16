<?php

namespace App\Livewire\Iptv\Calendar;

use App\Models\User;
use Livewire\Component;
use App\Models\CssColor;
use Illuminate\Support\Collection;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateCalendarEventForm;
use App\Models\Channel;
use App\Models\NanguIsp;
use App\Models\NanguIspTagToChannelPackage;
use App\Models\Tag;

class CreateCalendarEventComponent extends Component
{
    use NotificationTrait;
    public CreateCalendarEventForm $form;

    public bool $storeModal = false;

    public Collection $users;

    public Collection $cssColors;

    public Collection $channels;

    public array $tags;

    public function mount()
    {
        $this->cssColors = CssColor::get();
        $this->users = User::get();
        $this->channels = Channel::orderBy('name', "ASC")->get(['id', 'name']);
        if (NanguIspTagToChannelPackage::first()) {
            foreach (NanguIspTagToChannelPackage::distinct()->get('tag_id') as $nanguIspTagToChannelPackage) {

                $this->tags[] = [
                    'id' => $nanguIspTagToChannelPackage->tag_id,
                    'name' => Tag::find($nanguIspTagToChannelPackage->tag_id)->name
                ];
            }
        }
        // $this->tags =

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
        return $this->storeModal = false;
    }

    public function render()
    {
        return view('livewire.iptv.calendar.create-calendar-event-component');
    }
}
