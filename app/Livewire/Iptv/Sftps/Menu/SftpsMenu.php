<?php

namespace App\Livewire\Iptv\Sftps\Menu;

use App\Models\SftpServer;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

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
