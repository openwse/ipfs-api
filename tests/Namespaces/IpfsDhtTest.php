<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsDhtTest extends IpfsTestCase
{
    public function testItFindpeer(): void
    {
        // TODO: need peers to complete test
        $result = $this->ipfs->dht()->findpeer('QmcZf59bWwK5XFi76CZX8cbJ4BhTzzA3gU1ZjYZcYW3dwt', true);

        $this->assertIsArray($result);
    }

    public function testItFindprovs(): void
    {
        $resultAdd = $this->addSample();
        $result = $this->ipfs->dht()->findprovs($resultAdd['Hash'], true);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Extra', $result);
        $this->assertArrayHasKey('ID', $result);
        $this->assertArrayHasKey('Responses', $result);
        $this->assertArrayHasKey('Type', $result);
        $this->assertNotEmpty($result['Responses'][0]['Addrs']);
    }

    public function testItGet(): void
    {
        // TODO: need peers to complete test
        $resultAdd = $this->addSample();
        $this->ipfs->key()->gen('testkey');
        $resultPublish = $this->ipfs->name()->publish('/ipfs/'.$resultAdd['Hash'], '1h', 'testkey', true);

        $result = $this->ipfs->dht()->get('/ipns/'.$resultPublish['Name'], true);

        $this->assertIsArray($result);
    }

    // TODO: need peers to complete test
//    public function testItProvide(): void
//    {
//
//        $resultAdd = $this->addSample();
//
//        $result = $this->ipfs->dht()->provide([$resultAdd['Hash']]);
//
//        $this->assertIsArray($result);
//    }

    // TODO: need peers to complete test
//    public function testItPut(): void
//    {
//
//    }

    public function testItQuery(): void
    {
        // TODO: need peers to complete test
        $selfPeerID = $this->ipfs->config()->get('Identity.PeerID');
        $result = $this->ipfs->dht()->query($selfPeerID['Value'], true);

        $this->assertIsArray($result);
    }
}
