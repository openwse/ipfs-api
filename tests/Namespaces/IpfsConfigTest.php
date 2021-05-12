<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsConfigTest extends IpfsTestCase
{
    public function testItAppliesProfile(): void
    {
        $result = $this->ipfs->config()->applyProfile('server', true);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('OldCfg', $result);
        $this->assertArrayHasKey('NewCfg', $result);
    }

    public function testItGetsConfig(): void
    {
        $config = $this->ipfs->config()->show();

        $this->assertIsArray($config);
        $this->assertArrayHasKey('API', $config);
        $this->assertArrayHasKey('Addresses', $config);
        $this->assertArrayHasKey('AutoNAT', $config);
        $this->assertArrayHasKey('Bootstrap', $config);
        $this->assertArrayHasKey('Datastore', $config);
        $this->assertArrayHasKey('Discovery', $config);
        $this->assertArrayHasKey('Experimental', $config);
        $this->assertArrayHasKey('Gateway', $config);
        $this->assertArrayHasKey('Swarm', $config);
    }

    public function validConfigKeys(): iterable
    {
        yield ['Addresses.API'];
        yield ['Addresses.Swarm'];
        yield ['Gateway.PublicGateways'];
        yield ['Identity.PeerID'];
    }

    /**
     * @dataProvider validConfigKeys
     */
    public function testItGetsConfigKey(string $key): void
    {
        $config = $this->ipfs->config()->get($key);

        $this->assertIsArray($config);
        $this->assertArrayHasKey('Key', $config);
        $this->assertArrayHasKey('Value', $config);
        $this->assertEquals($key, $config['Key']);
    }

    public function configKeysValues(): iterable
    {
        yield ['Datastore.GCPeriod', '1h', false];
        yield ['Datastore.StorageMax', '5GB', false];
        yield ['Discovery.MDNS.Enabled', true, true];
        yield ['Experimental.GraphsyncEnabled', false, true];
    }

    /**
     * @dataProvider configKeysValues
     *
     * @param mixed $value
     */
    public function testItSetConfigValue(string $key, $value, bool $boolean): void
    {
        $config = $this->ipfs->config()->set($key, $value, $boolean);

        $this->assertIsArray($config);
        $this->assertArrayHasKey('Key', $config);
        $this->assertArrayHasKey('Value', $config);
        $this->assertEquals($key, $config['Key']);
        $this->assertEquals($value, $config['Value']);
    }
}
