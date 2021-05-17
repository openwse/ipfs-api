<?php

namespace Ipfs\Namespaces;

use GuzzleHttp\RequestOptions;
use Ipfs\IpfsNamespace;

class Repo extends IpfsNamespace
{
    /**
     * Remove repo lockfiles > is deprecated and does nothing.
     * Will return 404 not found.
     */
    public function fsck(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('repo/fsck')->send();
    }

    /**
     * Perform a garbage collection sweep on the repo.
     */
    public function gc(?bool $streamErrors = null, ?bool $quiet = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('repo/gc', [
            'stream-errors' => $streamErrors,
            'quiet' => $quiet,
        ])->send([RequestOptions::STREAM => $streamErrors === true]);
    }

    /**
     * Get stats for the currently used repo.
     */
    public function stat(?bool $sizeOnly = null, ?bool $human = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('repo/stat', [
            'size-only' => $sizeOnly,
            'human' => $human,
        ])->send();
    }

    /**
     * Verify all blocks in repo are not corrupted.
     */
    public function verify(): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('repo/verify')->send();
    }

    /**
     * Show the repo version.
     */
    public function version(?bool $quiet = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('repo/version', [
            'quiet' => $quiet,
        ])->send();
    }
}
