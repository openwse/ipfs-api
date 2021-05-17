<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Block extends IpfsNamespace
{
    /**
     * Get a raw IPFS block.
     */
    public function get(string $hash): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('block/get', [
            'arg' => $hash,
        ])->send();
    }

    /**
     * Store input as an IPFS block.
     *
     * @param array|string $files
     */
    public function put($files, ?string $format = null, string $mhtype = 'sha2-256', int $mhlen = -1, bool $pin = false): array
    {
        $request = $this->client->request('block/get', [
            'format' => $format,
            'mhtype' => $mhtype,
            'mhlen' => $mhlen,
            'pin' => $pin,
        ]);

        if (is_string($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            $request->attach($file);
        }

        /* @phpstan-ignore-next-line */
        return $request->send();
    }

    /**
     * Remove IPFS block(s).
     */
    public function rm(string $hash, ?bool $force = null, ?bool $quiet = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('block/rm', [
            'arg' => $hash,
            'force' => $force,
            'quiet' => $quiet,
        ])->send();
    }

    /**
     * Print information of a raw IPFS block.
     */
    public function stat(string $hash): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('block/stat', [
            'arg' => $hash,
        ])->send();
    }
}
