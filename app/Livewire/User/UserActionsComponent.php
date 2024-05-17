<?php

namespace App\Livewire\User;

use App\Models\Note;
use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserActionsComponent extends Component
{

    public Collection $notes;
    public Collection $events;
    public function mount()
    {
        $this->notes = Note::forUser(Auth::user()->email)->take(20)->get();
        $this->events = Event::forUser(Auth::user()->email)->take(20)->get();
    }

    public function render()
    {
        return view('livewire.user.user-actions-component');
    }
}
