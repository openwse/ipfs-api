<?php

namespace Ipfs;

use Ipfs\Contracts\IpfsClient;
use Ipfs\Namespaces\Bitswap;
use Ipfs\Namespaces\Block;
use Ipfs\Namespaces\Bootstrap;
use Ipfs\Namespaces\Cid;
use Ipfs\Namespaces\Config;
use Ipfs\Namespaces\Dag;
use Ipfs\Namespaces\Dht;
use Ipfs\Namespaces\Diag;
use Ipfs\Namespaces\Files;
use Ipfs\Namespaces\Filestore;
use Ipfs\Namespaces\Key;
use Ipfs\Namespaces\Log;
use Ipfs\Namespaces\Name;
use Ipfs\Namespaces\Obj;
use Ipfs\Namespaces\P2P;
use Ipfs\Namespaces\Pin;
use Ipfs\Namespaces\Pubsub;
use Ipfs\Namespaces\Repo;
use Ipfs\Namespaces\Stats;
use Ipfs\Namespaces\Swarm;
use Ipfs\Namespaces\Tar;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 *
 * @see https://docs.ipfs.io/
 */
class Ipfs
{
    private IpfsClient $client;

    public function __construct(IpfsClient $client)
    {
        $this->client = $client;
    }

    public function getClient(): IpfsClient
    {
        return $this->client;
    }

    /**
     * Add a file or directory to IPFS.
     *
     * @param string|array $files
     */
    public function add($files, bool $pin = false): array
    {
        $request = $this->client->request('add', [
            'pin' => $pin,
            'progress' => false,
            'wrap-with-directory' => false,
        ]);

        if (is_string($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            if (is_array($file)) {
                list($path, $name, $content, $mime) = $file;
                $request->attach($path, $name, $content, $mime);

                continue;
            }

            $request->attach($file);
        }

        /* @phpstan-ignore-next-line */
        return $request->send();
    }

    public function bitswap(): Bitswap
    {
        return new Bitswap($this->client);
    }

    public function block(): Block
    {
        return new Block($this->client);
    }

    public function bootstrap(): Bootstrap
    {
        return new Bootstrap($this->client);
    }

    /**
     * Show IPFS object data.
     */
    public function cat(string $path): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('cat', [
            'arg' => $path,
        ])->send();
    }

    public function cid(): Cid
    {
        return new Cid($this->client);
    }

    /**
     * List all available commands.
     */
    public function commands(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('commands', [
            'flags' => true,
        ])->send();
    }

    public function config(): Config
    {
        return new Config($this->client);
    }

    public function dag(): Dag
    {
        return new Dag($this->client);
    }

    public function dht(): Dht
    {
        return new Dht($this->client);
    }

    public function diag(): Diag
    {
        return new Diag($this->client);
    }

    /**
     * Resolve DNS links.
     */
    public function dns(string $domainName): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dns', [
            'arg' => $domainName,
        ])->send();
    }

    public function files(): Files
    {
        return new Files($this->client);
    }

    public function filestore(): Filestore
    {
        return new Filestore($this->client);
    }

    /**
     * Download IPFS objects.
     */
    public function get(string $path, bool $archive = false, bool $compress = false, int $compressLevel = 1): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('get', [
            'arg' => $path,
            'archive' => $archive,
            'compress' => $compress,
            'compression-level' => $compressLevel,
        ])->send();
    }

    /**
     * Show IPFS node id info.
     */
    public function id(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('id')->send();
    }

    public function key(): Key
    {
        return new Key($this->client);
    }

    public function log(): Log
    {
        return new Log($this->client);
    }

    /**
     * List directory contents for UnixFS objects.
     */
    public function ls(string $path, bool $headers = true, bool $resolveType = true, bool $size = true): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('ls', [
            'arg' => $path,
            'headers' => $headers,
            'resolve-type' => $resolveType,
            'size' => $size,
        ])->send();
    }

    public function name(): Name
    {
        return new Name($this->client);
    }

    public function object(): Obj
    {
        return new Obj($this->client);
    }

    public function p2p(): P2P
    {
        return new P2P($this->client);
    }

    public function pin(): Pin
    {
        return new Pin($this->client);
    }

    public function pubsub(): Pubsub
    {
        return new Pubsub($this->client);
    }

    public function repo(): Repo
    {
        return new Repo($this->client);
    }

    public function stats(): Stats
    {
        return new Stats($this->client);
    }

    public function swarm(): Swarm
    {
        return new Swarm($this->client);
    }

    public function tar(): Tar
    {
        return new Tar($this->client);
    }

    /**
     * Show IPFS version information.
     */
    public function version(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('version')->send();
    }
}
