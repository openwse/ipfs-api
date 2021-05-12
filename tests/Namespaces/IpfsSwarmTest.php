<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsSwarmTest extends IpfsTestCase
{
    public function testItGetsAddrs(): void
    {
        $result = $this->ipfs->swarm()->addrs();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Addrs', $result);
    }

    public function testItGetsAddrsListen(): void
    {
        $result = $this->ipfs->swarm()->addrsListen();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Strings', $result);
    }

    public function testItGetsAddrsLocal(): void
    {
        $result = $this->ipfs->swarm()->addrsLocal();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Strings', $result);
    }

    public function testItGetsFilters(): void
    {
        $result = $this->ipfs->swarm()->filters();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Strings', $result);
    }

    public function testItGetsPeers(): void
    {
        $result = $this->ipfs->swarm()->peers(true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Peers', $result);
    }
}
