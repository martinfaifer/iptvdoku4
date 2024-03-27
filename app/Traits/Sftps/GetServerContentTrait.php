<?php

namespace App\Traits\Sftps;

use phpseclib3\Net\SFTP;
use Illuminate\Support\Facades\Storage;

trait GetServerContentTrait
{
    public function get_content(object $sftpServer): array
    {
        if ($sftpServer->connection_type == 'sftp') {
            return $this->sftp($sftpServer);
        }

        if ($sftpServer->connection_type == 'ftp') {
            dd($this->ftp($sftpServer));
        }
    }

    public function sftp($sftpServer)
    {
        $sftp = new SFTP($sftpServer->url);

        if (!$sftp->login($sftpServer->username, $sftpServer->password)) {
            return [];
        }

        if (!$sftp->chdir($sftpServer->path_to_folder)) {
            $sftp->chdir("/");
        }

        $contents = $sftp->rawlist();
        $contentsCollection = collect($contents);
        $sorted = $contentsCollection->sortBy('filename');

        return array_values($sorted->values()->all());
    }

    public function ftp($sftpServer)
    {
        Storage::createFtpDriver([
            'host' => $sftpServer->url,
            'username' => $sftpServer->username,
            'password' => $sftpServer->password,
            'port' => '21',
        ])->files();
    }
}
