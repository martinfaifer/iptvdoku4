<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;
use phpseclib3\Net\SFTP;

class UploadSftpForm extends Form
{
    use WithFileUploads;

    #[Validate('required', message: 'Vyberte soubor')]
    public mixed $file = null;

    public function upload_file(object $sftpServer): bool
    {
        $sftp = new SFTP($sftpServer->url);

        if (! $sftp->login($sftpServer->username, $sftpServer->password)) {
            return false;
        }

        if (! $sftp->chdir($sftpServer->path_to_folder)) {
            return false;
        }

        if (! $sftp->put($this->file->getClientOriginalName(), $this->file->path(), SFTP::SOURCE_LOCAL_FILE)) {
            return false;
        }
        $this->reset();

        return true;
    }
}
