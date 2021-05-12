<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsStatsTest extends IpfsTestCase
{
    public function testItGetsBitswap(): void
    {
        $result = $this->ipfs->stats()->bitswap();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('ProvideBufLen', $result);
        $this->assertArrayHasKey('Wantlist', $result);
        $this->assertArrayHasKey('Peers', $result);
        $this->assertArrayHasKey('BlocksReceived', $result);
    }

    public function testItGetsBw(): void
    {
        $result = $this->ipfs->stats()->bw();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('TotalIn', $result);
        $this->assertArrayHasKey('TotalOut', $result);
        $this->assertArrayHasKey('RateIn', $result);
        $this->assertArrayHasKey('RateOut', $result);
    }

    public function testItGetsDhtNodes(): void
    {
        $result = $this->ipfs->stats()->dht();
        $this->assertIsArray($result);
        $this->assertEquals(2, count($result));
        $this->assertContains('wan', array_column($result, 'Name'));
        $this->assertContains('lan', array_column($result, 'Name'));
    }

    public function testItGetsSingleDht(): void
    {
        $result = $this->ipfs->stats()->dht('wan');
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Name', $result);
        $this->assertArrayHasKey('Buckets', $result);
    }

    public function testItGetsRepo(): void
    {
        $result = $this->ipfs->stats()->repo();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('RepoSize', $result);
        $this->assertArrayHasKey('StorageMax', $result);
        $this->assertArrayHasKey('NumObjects', $result);
        $this->assertArrayHasKey('RepoPath', $result);
        $this->assertArrayHasKey('Version', $result);
    }
}
