<?php

namespace Ipfs\Contracts;

use Psr\Http\Message\StreamInterface;

interface IpfsClient
{
    /**
     * @param string|resource|null $content
     */
    public function attach(string $path, ?string $name = null, $content = null, ?string $mime = null): IpfsClient;

    public function request(string $url, array $payload = []): IpfsClient;

    /**
     * @return array|resource|StreamInterface
     */
    public function send(array $options = []);
}
