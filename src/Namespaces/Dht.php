<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Dht extends IpfsNamespace
{
    /**
     * Find the multiaddresses associated with a Peer ID.
     */
    public function findpeer(string $peerId, ?bool $verbose = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dht/findpeer', [
            'arg' => $peerId,
            'verbose' => $verbose,
        ])->send();
    }

    /**
     * Find peers that can provide a specific value, given a key.
     */
    public function findprovs(string $key, ?bool $verbose = null, int $numProviders = 20): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dht/findprovs', [
            'arg' => $key,
            'verbose' => $verbose,
            'num-providers' => $numProviders,
        ])->send();
    }

    /**
     * Given a key, query the routing system for its best value.
     */
    public function get(string $key, ?bool $verbose = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dht/get', [
            'arg' => $key,
            'verbose' => $verbose,
        ])->send();
    }

    /**
     * Announce to the network that you are providing given values.
     */
    public function provide(array $keys, ?bool $verbose = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dht/provide', [
            'arg' => $keys,
            'verbose' => $verbose,
        ])->send();
    }

    /**
     * Write a key/value pair to the routing system.
     */
    public function put(string $file, array $key, ?bool $verbose = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dht/put', [
            'arg' => $key,
            'verbose' => $verbose,
        ])->attach($file)->send();
    }

    /**
     * Find the closest Peer IDs to a given Peer ID by querying the DHT.
     */
    public function query(string $peerId, ?bool $verbose = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dht/query', [
            'arg' => $peerId,
            'verbose' => $verbose,
        ])->send();
    }
}
