<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Bootstrap extends IpfsNamespace
{
    /**
     * Add peers to the bootstrap list.
     */
    public function add(string $peer): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('bootstrap/add', [
            'arg' => $peer,
        ])->send();
    }

    /**
     * Add default peers to the bootstrap list.
     */
    public function addDefault(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('bootstrap/add/default')->send();
    }

    /**
     * Show peers in the bootstrap list.
     */
    public function list(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('bootstrap/list')->send();
    }

    /**
     * Remove peers from the bootstrap list.
     */
    public function rm(string $peer): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('bootstrap/rm', [
            'arg' => $peer,
        ])->send();
    }

    /**
     * Remove all peers from the bootstrap list.
     */
    public function rmAll(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('bootstrap/rm/all')->send();
    }
}
