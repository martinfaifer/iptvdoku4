<?php

namespace App\Traits\Sftps;

use App\Models\SftpServer;
use Illuminate\Support\Facades\Storage;
use phpseclib3\Net\SFTP;

trait GetServerContentTrait
{
    public function get_content(SftpServer $sftpServer): array
    {
        if ($sftpServer->connection_type == 'sftp') {
            return $this->sftp($sftpServer);
        }

        // if ($sftpServer->connection_type == 'ftp') {
        //     dd($this->ftp($sftpServer));
        // }

        return [];
    }

    public function sftp(SftpServer $sftpServer): array
    {
        $sftp = new SFTP($sftpServer->url);

        if (! $sftp->login($sftpServer->username, $sftpServer->password)) {
            return [];
        }

        if (! $sftp->chdir($sftpServer->path_to_folder)) {
            $sftp->chdir('/');
        }

        $contents = $sftp->rawlist();
        $contentsCollection = collect($contents);  // @phpstan-ignore-line
        $sorted = $contentsCollection->sortBy('filename');

        return array_values($sorted->values()->all());
    }

    public function ftp(SftpServer $sftpServer): array
    {
        return Storage::createFtpDriver([
            'host' => $sftpServer->url,
            'username' => $sftpServer->username,
            'password' => $sftpServer->password,
            'port' => '21',
        ])->files();
    }
}
