<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Cid extends IpfsNamespace
{
    /**
     * Convert CIDs to Base32 CID version 1.
     */
    public function base32(string $cidToConvert): array
    {
        return $this->client->request('cid/base32', [
            'arg' => $cidToConvert,
        ])->send();
    }

    /**
     * List available multibase encodings.
     */
    public function bases(?bool $prefix = null, ?bool $numeric = null): array
    {
        return $this->client->request('cid/bases', [
            'prefix' => $prefix,
            'numeric' => $numeric,
        ])->send();
    }

    /**
     * List available CID codecs.
     */
    public function codecs(?bool $numeric = null): array
    {
        return $this->client->request('cid/codecs', [
            'numeric' => $numeric,
        ])->send();
    }

    /**
     * Format and convert a CID in various useful ways.
     */
    public function format(string $cid, ?string $format = null, ?string $version = null, ?string $codec = null, ?string $base = null): array
    {
        return $this->client->request('cid/format', [
            'arg' => $cid,
            'f' => $format,
            'v' => $version,
            'codec' => $codec,
            'b' => $base,
        ])->send();
    }

    /**
     * List available multihashes.
     */
    public function hashes(?bool $numeric = null): array
    {
        return $this->client->request('cid/hashes', [
            'numeric' => $numeric,
        ])->send();
    }
}
