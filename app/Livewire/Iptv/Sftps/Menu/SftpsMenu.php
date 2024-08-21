<?php

namespace App\Livewire\Iptv\Sftps\Menu;

use Livewire\Component;
use App\Models\SftpServer;
use Livewire\Attributes\On;
use Illuminate\Support\Collection;
use App\Livewire\Iptv\Sftps\Factory;

class SftpsMenu extends Component
{
    public Collection $sftpServers;

    public function mount(): void
    {
        $this->sftpServers = SftpServer::get(['id', 'name']);
    }

    #[On('refresh_sftp_servers')]
    public function refreshStpServer(): void
    {
        $this->sftpServers = SftpServer::get(['id', 'name']);
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.sftps.menu.sftps-menu');
    }
}
