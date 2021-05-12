<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Config extends IpfsNamespace
{
    public function applyProfile(string $profile, ?bool $dryRun = null): array
    {
        return $this->client->request('config/profile/apply', [
            'arg' => $profile,
            'dry-run' => $dryRun,
        ])->send();
    }

    /**
     * Get IPFS config values.
     */
    public function get(string $key): array
    {
        return $this->client->request('config', [
            'arg' => $key,
        ])->send();
    }

    /**
     * Replace the config with a given file.
     */
    public function replace(string $configFile): array
    {
        return $this->client
            ->request('replace', [])
            ->attach($configFile)
            ->send()
        ;
    }

    /**
     * Set IPFS config values.
     *
     * @param mixed $value
     */
    public function set(string $key, $value, ?bool $boolean = null, ?bool $json = null): array
    {
        return $this->client->request('config', [
            'args' => [
                $key,
                $value,
            ],
            'bool' => $boolean,
            'json' => $json,
        ])->send();
    }

    /**
     * Output config file contents.
     */
    public function show(): array
    {
        return $this->client->request('config/show')->send();
    }
}
