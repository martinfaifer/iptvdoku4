<?php

namespace App\Livewire\Nangu\IpPrefixes;

use App\Models\Ip;
use App\Models\Note;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class DeleteNanguIpPrefixesComponent extends Component
{
    use NotificationTrait;

    public ?Ip $prefix;

    public function mount(Ip $prefix)
    {
        $this->prefix = $prefix;
    }

    public function destroy()
    {
        try {
            Note::where('ip_id', $this->prefix->id)->delete();
        } catch (\Throwable $th) {
            //throw $th;
        }
        $this->prefix->delete();

        $this->redirect('/prefixes', true);

        return $this->success_alert('Odebráno');
    }

    public function render()
    {
        return view('livewire.nangu.ip-prefixes.delete-nangu-ip-prefixes-component');
    }
}
