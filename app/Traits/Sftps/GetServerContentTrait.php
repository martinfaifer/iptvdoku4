<?php

namespace App\Traits\Sftps;

use phpseclib3\Net\SFTP;

trait GetServerContentTrait
{
    public function get_content(object $sftpServer): array
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

        // $sorted->values()->all();

        return array_values($sorted->values()->all());
    }
}
