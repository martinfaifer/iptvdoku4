<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use phpseclib3\Net\SFTP;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class UploadSftpForm extends Form
{
    use WithFileUploads;

    #[Validate('required', message: "Vyberte soubor")]
    public $file = null;

    public function upload_file($sftpServer): bool
    {
        $sftp = new SFTP($sftpServer->url);

        if (!$sftp->login($sftpServer->username, $sftpServer->password)) {
            return false;
        }

        if (!$sftp->chdir($sftpServer->path_to_folder)) {
            return false;
        }

        if (!$sftp->put($this->file->getClientOriginalName(), $this->file->path(), SFTP::SOURCE_LOCAL_FILE)) {
            return false;
        }
        $this->reset();
        return true;
    }
}
