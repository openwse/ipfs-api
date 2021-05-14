<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Name extends IpfsNamespace
{
    /**
     * Publish IPNS names.
     */
    public function publish(string $path, string $lifetime = '24h', string $key = 'self', bool $offline = false, bool $allowOffline = true): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('name/publish', [
            'arg' => $path,
            'resolve' => true,
            'key' => $key,
            'offline' => $offline,
            'lifetime' => $lifetime,
            'allow-offline' => $allowOffline,
        ])->send();
    }

//    /**
//     * Cancel a name subscription.
//     */
//    public function pubsubCancel(string $name): array
//    {
//        return $this->client->request('name/pubsub/cancel', [
//            'arg' => $name,
//        ])->send();
//    }
//
//    /**
//     * Query the state of IPNS pubsub.
//     */
//    public function pubsubState(string $path): array
//    {
//        return $this->client->request('name/pubsub/state')->send();
//    }
//
//    /**
//     * Show current name subscriptions.
//     */
//    public function pubsubSubs(): array
//    {
//        return $this->client->request('name/pubsub/subs')->send();
//    }

    /**
     * Resolve IPNS names.
     */
    public function resolve(string $path, bool $noCache = true, int $dhtTimeout = 0): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('name/resolve', [
            'arg' => $path,
            'nocache' => $noCache,
            'dht-timeout' => $dhtTimeout,
        ])->send();
    }
}
