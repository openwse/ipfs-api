<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Key extends IpfsNamespace
{
    /**
     * Export a keypair.
     */
    public function export(string $name): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('key/export', [
            'arg' => $name,
        ])->send();
    }

    /**
     * Create a new keypair.
     */
    public function gen(string $name, string $type = 'ed25519', ?int $size = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('key/gen', [
            'arg' => $name,
            'type' => $type,
            'size' => $size,
        ])->send();
    }

    /**
     * Create a new keypair.
     */
    public function import(string $name, string $file): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('key/import', [
            'arg' => $name,
        ])->attach($file)->send();
    }

    /**
     * List all local keypairs.
     */
    public function list(bool $long = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('key/list', [
            'l' => $long,
        ])->send();
    }

    /**
     * Rename a keypair.
     */
    public function rename(string $oldName, string $newName, bool $force = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('key/rename', [
            'arg' => [
                $oldName,
                $newName,
            ],
            'force' => $force,
        ])->send();
    }

    /**
     * Remove a keypair.
     */
    public function rm(string $name, bool $long = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('key/rm', [
            'arg' => $name,
            'l' => $long,
        ])->send();
    }

    /**
     * Rotates the IPFS identity.
     */
    public function rotate(?string $oldKey = null, string $type = 'ed25519', ?int $size = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('key/rotate', [
            'oldkey' => $oldKey,
            'type' => $type,
            'size' => $size,
        ])->send();
    }
}
