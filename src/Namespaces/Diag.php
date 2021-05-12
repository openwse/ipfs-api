<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Diag extends IpfsNamespace
{
    /**
     * List commands run on this IPFS node.
     */
    public function cmds(?bool $verbose = false): array
    {
        return $this->client->request('diag/cmds', [
            'verbose' => $verbose,
        ])->send();
    }

    /**
     * Clear inactive requests from the log.
     */
    public function cmdsClear(): array
    {
        return $this->client->request('diag/cmds/clear')->send();
    }

    /**
     * Set how long to keep inactive requests in the log.
     */
    public function cmdsSetTime(string $time): array
    {
        return $this->client->request('diag/cmds/set-time', [
            'arg' => $time, // Valid time units are "ns", "us" (or "µs"), "ms", "s", "m", "h".
        ])->send();
    }

    /**
     * Print system diagnostic information.
     */
    public function sys(): array
    {
        return $this->client->request('diag/sys')->send();
    }
}
