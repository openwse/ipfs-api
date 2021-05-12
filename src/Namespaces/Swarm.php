<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Swarm extends IpfsNamespace
{
    /**
     * List known addresses. Useful for debugging.
     */
    public function addrs(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('swarm/addrs')->send();
    }

    /**
     * List interface listening addresses.
     */
    public function addrsListen(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('swarm/addrs/listen')->send();
    }

    /**
     * List local addresses.
     */
    public function addrsLocal(bool $id = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('swarm/addrs/local', [
            'id' => $id,
        ])->send();
    }

    /**
     * Open connection to a given address.
     */
    public function connect(string $address): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('swarm/connect', [
            'arg' => $address,
        ])->send();
    }

    /**
     * Close connection to a given address.
     */
    public function disconnect(string $address): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('swarm/disconnect', [
            'arg' => $address,
        ])->send();
    }

    /**
     * Manipulate address filters.
     */
    public function filters(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('swarm/filters')->send();
    }

    /**
     * Add an address filter.
     */
    public function filtersAdd(string $address): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('swarm/filters/add', [
            'arg' => $address,
        ])->send();
    }

    /**
     * Remove an address filter.
     */
    public function filtersRm(string $address): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('swarm/filters/rm', [
            'arg' => $address,
        ])->send();
    }

    /**
     * List peers with open connections.
     */
    public function peers(bool $verbose = false, bool $streams = false, bool $latency = false, bool $direction = false): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('swarm/peers', [
            'verbose' => $verbose,
            'streams' => $streams,
            'latency' => $latency,
            'direction' => $direction,
        ])->send();
    }
}
