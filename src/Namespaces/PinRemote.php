<?php

namespace Ipfs\Namespaces;

use Ipfs\Contracts\IpfsClient;
use Ipfs\IpfsNamespace;

class PinRemote extends IpfsNamespace
{
    public const ALL_STATUSES = ['queued', 'pinning', 'pinned', 'failed'];

    protected string $service;

    public function __construct(IpfsClient $client, string $service)
    {
        parent::__construct($client);
        $this->service = $service;
    }

    /**
     * Pin object to remote storage.
     */
    public function add(string $cid, ?string $name = null, bool $background = true, ?array $meta = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/remote/add', [
            'arg' => $cid,
            'background' => $background,
            'name' => $name,
            'meta' => (! is_null($meta)) ? json_encode($meta) : null,
            'service' => $this->service,
        ])->send();
    }

    public function get(string $cid): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/remote/get', [
            'arg' => $cid,
            'service' => $this->service,
        ])->send();
    }

    /**
     * List objects pinned to remote storage.
     * Where status can be all of: queued, pinning, pinned, failed.
     * Where match can be one of:  exact, iexact, partial, ipartial.
     *
     * Datetime-string example: 2020-07-27T17:32:28Z
     */
    public function ls(?array $cids = null, ?string $name = null, array $statuses = ['pinned'], int $limit = 10, string $match = 'exact', ?string $before = null, ?string $after = null, ?array $meta = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/remote/ls', [
            'cid' => $cids,
            'name' => $name,
            'match' => $match,
            'status' => $statuses,
            'limit' => $limit,
            'before' => $before,
            'after' => $after,
            'meta' => (! is_null($meta)) ? json_encode($meta) : null,
            'service' => $this->service,
        ])->send();
    }

    /**
     * Remove pinned objects from remote storage.
     */
    public function rm(?array $cids = null, ?string $name = null, array $statuses = ['pinned'], bool $force = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/remote/rm', [
            'cid' => $cids,
            'name' => $name,
            'status' => $statuses,
            'force' => $force,
            'service' => $this->service,
        ])->send();
    }
}
