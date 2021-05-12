<?php

namespace Ipfs\Contracts;

interface IpfsClient
{
    public function attach(string $fileOrDir, ?string $name = null): IpfsClient;

    public function request(string $url, array $payload = []): IpfsClient;

    public function send(array $options = []): array;
}
