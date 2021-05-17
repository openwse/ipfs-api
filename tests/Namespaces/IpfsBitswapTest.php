<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\IpfsException;
use Ipfs\Tests\IpfsTestCase;

class IpfsBitswapTest extends IpfsTestCase
{
    public function testItGetsLedger(): void
    {
        $selfPeerID = $this->ipfs->config()->get('Identity.PeerID');
        $result = $this->ipfs->bitswap()->ledger($selfPeerID['Value']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Peer', $result);
        $this->assertArrayHasKey('Value', $result);
        $this->assertArrayHasKey('Sent', $result);
        $this->assertArrayHasKey('Recv', $result);
        $this->assertArrayHasKey('Exchanged', $result);

        $this->assertEquals($selfPeerID['Value'], $result['Peer']);
    }

    public function testItReprovide(): void
    {
        $this->expectException(IpfsException::class);
        $this->expectExceptionMessage('reprovider is already running');
        $this->ipfs->bitswap()->reprovide();
    }

    public function testItGetsStats(): void
    {
        $result = $this->ipfs->bitswap()->stat(true, true);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('ProvideBufLen', $result);
        $this->assertArrayHasKey('Wantlist', $result);
        $this->assertArrayHasKey('Peers', $result);
        $this->assertArrayHasKey('BlocksReceived', $result);
        $this->assertArrayHasKey('DataReceived', $result);
    }

    public function testItGetsWantlist(): void
    {
        $selfPeerID = $this->ipfs->config()->get('Identity.PeerID');
        $result = $this->ipfs->bitswap()->wantlist($selfPeerID['Value']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Keys', $result);
    }
}
