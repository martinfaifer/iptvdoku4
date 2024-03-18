<?php

namespace App\Livewire\Iptv\Sftps\Menu;

use Livewire\Component;
use App\Models\SftpServer;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;

class SftpsMenu extends Component
{

    public Collection $sftpServers;

    public function mount()
    {
        $this->sftpServers = SftpServer::get(['id', 'name']);
    }

    #[On('refresh_sftp_servers')]
    public function refreshStpServer()
    {
        return $this->sftpServers = SftpServer::get(['id', 'name']);
    }

    public function render()
    {
        return view('livewire.iptv.sftps.menu.sftps-menu');
    }
}
