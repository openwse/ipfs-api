<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsBootstrapTest extends IpfsTestCase
{
    public function testItAdd(): void
    {
        $result = $this->ipfs->bootstrap()->add($peer = '/dnsaddr/bootstrap.libp2p.io/p2p/QmNnooDu7bfjPFoTZYxMNLWUQJyrVwtbZg5gBMjTezGAJN');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Peers', $result);
        $this->assertContains($peer, $result['Peers']);
    }

    public function testItAddDefault(): void
    {
        $result = $this->ipfs->bootstrap()->addDefault();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Peers', $result);
    }

    public function testItList(): void
    {
        $result = $this->ipfs->bootstrap()->list();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Peers', $result);
    }

    public function testItRm(): void
    {
        $peers = $this->ipfs->bootstrap()->list();
        $result = $this->ipfs->bootstrap()->rm($firstPeer = $peers['Peers'][0]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Peers', $result);
        $this->assertContains($firstPeer, $result['Peers']);
    }

    public function testItRmAll(): void
    {
        $result = $this->ipfs->bootstrap()->rmAll();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Peers', $result);

        $resultLs = $this->ipfs->bootstrap()->list();
        $this->assertEquals(0, count($resultLs['Peers']));
    }
}
