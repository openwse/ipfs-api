<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class PinService extends IpfsNamespace
{
    public function add(string $name, string $endpoint, string $token): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/remote/service/add', [
            'arg' => [
                $name,
                $endpoint,
                $token,
            ],
        ])->send();
    }

    public function ls(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/remote/service/ls')->send();
    }

    public function rm(string $name): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('pin/remote/service/rm', [
            'arg' => $name,
        ])->send();
    }
}
