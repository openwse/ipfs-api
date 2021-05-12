<?php

namespace Ipfs\Namespaces;

use GuzzleHttp\RequestOptions;
use Ipfs\IpfsNamespace;
use Psr\Http\Message\StreamInterface;

class Files extends IpfsNamespace
{
    /**
     * Change the CID version or hash function of the root node of a given path.
     */
    public function chcid(string $path = '/', ?int $cidVersion = null, ?string $hash = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('files/chcid', [
            'arg' => $path,
            'cid-version' => $cidVersion,
            'hash' => $hash,
        ])->send();
    }

    /**
     * Copy any IPFS files and directories into MFS (or copy within MFS).
     */
    public function cp(string $source, string $destination): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('files/cp', [
            'args' => [
                $source,
                $destination,
            ],
        ])->send();
    }

    /**
     * Flush a given path's data to disk.
     */
    public function flush(string $path = '/'): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('files/flush', [
            'arg' => $path,
        ])->send();
    }

    /**
     * List directories in the local mutable namespace.
     */
    public function ls(string $path = '/', bool $long = false, bool $sort = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('files/ls', [
            'arg' => $path,
            'long' => $long,
            'U' => $sort,
        ])->send();
    }

    /**
     * Make directories.
     */
    public function mkdir(string $path, bool $parents = true, ?int $cidVersion = null, ?string $hash = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('files/mkdir', [
            'arg' => $path,
            'parents' => $parents,
            'cid-version' => $cidVersion,
            'hash' => $hash,
        ])->send();
    }

    /**
     * Move files.
     */
    public function mv(string $source, string $destination): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('files/mv', [
            'args' => [
                $source,
                $destination,
            ],
        ])->send();
    }

    /**
     * Read a file in a given MFS.
     *
     * @return array|resource|StreamInterface
     */
    public function read(string $path, bool $stream = false)
    {
        return $this->client->request('files/read', [
            'arg' => $path,
        ])->send([RequestOptions::STREAM => $stream]);
    }

    /**
     * Remove a file.
     */
    public function rm(string $path, bool $force = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('files/rm', [
            'arg' => $path,
            'force' => $force,
        ])->send();
    }

    /**
     * Display file status.
     */
    public function stat(string $path): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('files/stat', [
            'arg' => $path,
        ])->send();
    }
}
