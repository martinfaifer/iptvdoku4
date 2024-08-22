<?php

namespace App\Livewire\Iptv\Sftps;

use App\Models\SftpServer;
use App\Traits\Livewire\NotificationTrait;
use Livewire\Component;

class DeleteSftpServerComponent extends Component
{
    use NotificationTrait;

    public ?SftpServer $sftpServer;

    public function destroy(): mixed
    {
        $this->redirect('/sftps', true);
        $this->sftpServer->delete();

        return $this->success_alert('Odebráno');
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.sftps.delete-sftp-server-component');
    }
}
