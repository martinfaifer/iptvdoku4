<?php

namespace App\Livewire\User;

use App\Models\Event;
use App\Models\Loger;
use App\Models\Note;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserActionsComponent extends Component
{
    public Collection $notes;

    public Collection $events;

    public Collection $logs;

    public function mount()
    {
        $this->notes = Note::forUser(Auth::user()->email)->take(20)->get();
        $this->events = Event::forUser(Auth::user()->email)->take(20)->get();
        $this->logs = Loger::forUser(Auth::user()->email)->take(20)->get();
    }

    public function render()
    {
        return view('livewire.user.user-actions-component');
    }
}
