<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Filestore extends IpfsNamespace
{
    /**
     * List blocks that are both in the filestore and standard block storage.
     */
    public function dups(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('filestore/dups')->send();
    }

    /**
     * List objects in filestore.
     */
    public function list(string $cid, ?bool $fileOrder = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('filestore/list', [
            'arg' => $cid,
            'file-order' => $fileOrder,
        ])->send();
    }

    /**
     * Verify objects in filestore.
     */
    public function verify(string $cid, ?bool $fileOrder = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('filestore/verify', [
            'arg' => $cid,
            'file-order' => $fileOrder,
        ])->send();
    }
}
