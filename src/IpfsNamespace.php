<?php

namespace Ipfs;

use Ipfs\Contracts\IpfsClient;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 *
 * @see https://docs.ipfs.io/
 */
class IpfsNamespace
{
    protected IpfsClient $client;

    public function __construct(IpfsClient $client)
    {
        $this->client = $client;
    }
}
