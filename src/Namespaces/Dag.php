<?php

namespace Ipfs\Namespaces;

use GuzzleHttp\RequestOptions;
use Ipfs\IpfsNamespace;
use Psr\Http\Message\StreamInterface;

class Dag extends IpfsNamespace
{
    /**
     * Streams the selected DAG as a .car stream on stdout.
     *
     * @return array|resource|StreamInterface
     */
    public function export(string $cid, ?bool $progress = null)
    {
        return $this->client->request('dag/export', [
            'arg' => $cid,
            'progress' => $progress,
        ])->send([RequestOptions::STREAM => $progress === true]);
    }

    /**
     * Get a dag node from IPFS.
     */
    public function get(string $object): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dag/export', [
            'arg' => $object,
        ])->send();
    }

    /**
     * Import the contents of .car files.
     *
     * @param array|string $files
     */
    public function import($files, ?bool $silent = null, bool $pinRoots = true): array
    {
        $request = $this->client->request('dag/import', [
            'silent' => $silent,
            'pin-roots' => $pinRoots,
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
     * Add a dag node to IPFS.
     */
    public function put(string $file, string $format = 'cbor', string $inputEnc = 'json', ?bool $pin = null, ?string $hash = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dag/put', [
            'format' => $format,
            'input-enc' => $inputEnc,
            'pin' => $pin,
            'hash' => $hash,
        ])->attach($file)->send();
    }

    /**
     * Resolve IPLD block.
     */
    public function resolve(string $path): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dag/resolve', [
            'arg' => $path,
        ])->send();
    }

    /**
     * Gets stats for a DAG.
     */
    public function stat(string $cid, bool $progress = true): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('dag/stat', [
            'arg' => $cid,
            'progress' => $progress,
        ])->send();
    }
}
