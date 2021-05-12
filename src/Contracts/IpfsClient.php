<?php

namespace Ipfs\Contracts;

interface IpfsClient
{
    public function attach(string $path, ?string $name = null, ?string $content = null, ?string $mime = null): IpfsClient;

    public function request(string $url, array $payload = []): IpfsClient;

    public function send(array $options = []): array;
}
