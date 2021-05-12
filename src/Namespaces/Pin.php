<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Pin extends IpfsNamespace
{
    /**
     * Pin objects to local storage.
     */
    public function add(string $paths, bool $progress = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/add', [
            'arg' => $paths,
            'progress' => $progress,
        ])->send();
    }

    /**
     * List objects pinned to local storage.
     * Where type is one of: direct, indirect, recursive, all.
     */
    public function ls(string $paths, string $type = 'all', bool $quiet = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/ls', [
            'arg' => $paths,
            'type' => $type,
            'quiet' => $quiet,
        ])->send();
    }

    /**
     * Remove pinned objects from local storage.
     */
    public function rm(string $paths): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/rm', [
            'arg' => $paths,
        ])->send();
    }

    /**
     * Update a recursive pin.
     */
    public function update(string $oldPath, string $newPath, bool $unpin = true): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/update', [
            'args' => [
                $oldPath,
                $newPath,
            ],
            'unpin' => $unpin,
        ])->send();
    }

    /**
     * Verify that recursive pins are complete.
     */
    public function verify(bool $verbose = true, bool $quiet = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/verify', [
            'verbose' => $verbose,
            'quiet' => $quiet,
        ])->send();
    }
}
