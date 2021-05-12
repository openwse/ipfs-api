<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Stats extends IpfsNamespace
{
    /**
     * Show some diagnostic information on the bitswap agent.
     */
    public function bitswap(bool $verbose = false, bool $human = false): array
    {
        return $this->client->request('stats/bitswap', [
            'verbose' => $verbose,
            'human' => $human,
        ])->send();
    }

    /**
     * Print IPFS bandwidth information.
     */
    public function bw(?string $peer = null, ?string $proto = null): array
    {
        return $this->client->request('stats/bw', [
            'peer' => $peer,
            'proto' => $proto,
        ])->send();
    }

    /**
     * Returns statistics about the node's DHT(s).
     */
    public function dht(?string $dht = null): array
    {
        return $this->client->request('stats/dht', [
            'arg' => $dht,
        ])->send();
    }

    /**
     * Get stats for the currently used repo.
     */
    public function repo(bool $sizeOnly = false, bool $human = false): array
    {
        return $this->client->request('stats/repo', [
            'size-only' => $sizeOnly,
            'human' => $human,
        ])->send();
    }
}
