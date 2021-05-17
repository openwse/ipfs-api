<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Bitswap extends IpfsNamespace
{
    /**
     * Show the current ledger for a peer.
     */
    public function ledger(string $peerId): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('bitswap/ledger', [
            'arg' => $peerId,
        ])->send();
    }

    /**
     * Trigger reprovider to announce our data to network.
     */
    public function reprovide(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('bitswap/reprovide')->send();
    }

    /**
     * Show some diagnostic information on the bitswap agent.
     */
    public function stat(?bool $verbose = null, ?bool $human = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('bitswap/stat', [
            'verbose' => $verbose,
            'human' => $human,
        ])->send();
    }

    /**
     * Show blocks currently on the wantlist.
     */
    public function wantlist(?string $peer = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('bitswap/wantlist', [
            'peer' => $peer,
        ])->send();
    }
}
