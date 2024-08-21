<?php

namespace App\Livewire\Iptv\Sftps;

use App\Livewire\Forms\UploadSftpForm;
use App\Models\SftpServer;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Sftps\GetServerContentTrait;
use Livewire\Component;
use Livewire\WithFileUploads;
use phpseclib3\Net\SFTP;

class SftpComponent extends Component
{
    use GetServerContentTrait, NotificationTrait, WithFileUploads;

    public ?SftpServer $sftpServer;

    public UploadSftpForm $uploadForm;

    public array $sftpServerContent;

    public bool $uploadDialog = false;

    public function mount(): void
    {
        try {
            $this->sftpServerContent = $this->get_content($this->sftpServer);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function openUploadDialog(): void
    {
        $this->uploadDialog = true;
    }

    public function closeDialog(): void
    {
        $this->resetErrorBag();

        $this->uploadDialog = false;
    }

    public function upload_file(): mixed
    {
        $this->authorize('upload', SftpServer::class);
        if ($this->uploadForm->upload_file($this->sftpServer) == true) {
            $this->closeDialog();
            $this->redirect('/sftps/'.$this->sftpServer->id, true);

            return $this->success_alert('Soubor nahrán');
        }
        $this->closeDialog();

        return $this->error('Soubor se nepodařilo nahrát');
    }

    public function download_file(array $item): mixed
    {
        $sftp = new SFTP($this->sftpServer->url);

        if (! $sftp->login($this->sftpServer->username, $this->sftpServer->password)) {
            return $this->error_alert('Nepodařilo se přihlásit do serveru');
        }

        if (! $sftp->file_exists($this->sftpServer->path_to_folder.$item['filename'])) {
            return $this->error_alert('Nepodařilo se najít soubor');
        }

        return response()->streamDownload(
            function () use ($sftp, $item) {
                echo $sftp->get($this->sftpServer->path_to_folder.$item['filename']);
            },
            $item['filename']
        );
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.sftps.sftp-component');
    }
}
