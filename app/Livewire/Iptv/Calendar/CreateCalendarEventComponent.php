<?php

namespace App\Livewire\Iptv\Calendar;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateCalendarEventForm;
use App\Models\User;

class CreateCalendarEventComponent extends Component
{
    use NotificationTrait;
    public CreateCalendarEventForm $form;

    public bool $storeModal = false;

    public Collection $users;


    public function mount()
    {
        return $this->users = User::get();
    }

    public function create()
    {
        $this->form->create();
        $this->redirect('/calendar', true);
        $this->closeModal();
        return $this->success_alert("Odebráno");
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
