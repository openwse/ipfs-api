<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Tar extends IpfsNamespace
{
    /**
     * Import a tar file into IPFS.
     */
    public function add(string $file): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('tar/add')->attach($file)->send();
    }

    /**
     * Export a tar file from IPFS.
     */
    public function cat(string $path): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('tar/cat', [
            'arg' => $path,
        ])->send();
    }
}
