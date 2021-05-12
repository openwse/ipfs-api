<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Log extends IpfsNamespace
{
    /**
     * Change the logging level.
     * Where level is one of: debug, info, warn, error, dpanic, panic, fatal.
     */
    public function level(string $subsystem = 'all', string $level = 'fatal'): array
    {
        return $this->client->request('log/level', [
            'args' => [
                $subsystem,
                $level,
            ],
        ])->send();
    }

    /**
     * List the logging subsystems.
     */
    public function ls(): array
    {
        return $this->client->request('log/ls')->send();
    }
}
