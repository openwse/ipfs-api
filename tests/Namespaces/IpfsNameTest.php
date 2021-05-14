<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\IpfsException;
use Ipfs\Tests\IpfsTestCase;

class IpfsNameTest extends IpfsTestCase
{
    public function testItPublish(): void
    {
        $resultAdd = $this->addSample();
        $this->assertIsArray($resultAdd);

        $this->ipfs->key()->gen('mykey');
        $resultPublish = $this->ipfs->name()->publish($path = '/ipfs/'.$resultAdd['Hash'], '1h', 'mykey', true);

        $this->assertIsArray($resultPublish);
        $this->assertArrayHasKey('Name', $resultPublish);
        $this->assertArrayHasKey('Value', $resultPublish);
        $this->assertEquals($path, $resultPublish['Value']);
    }

    public function testItExpires(): void
    {
        $resultAdd = $this->addSample();

        $this->ipfs->key()->gen('mykey');
        $resultPublish = $this->ipfs->name()->publish('/ipfs/'.$resultAdd['Hash'], '2s', 'mykey', true);

        sleep(2);

        $this->expectException(IpfsException::class);
        $this->expectExceptionMessage('could not resolve name');
        $this->ipfs->name()->resolve($resultPublish['Name']);
    }

    public function testItResolve(): void
    {
        $resultAdd = $this->addSample();

        $this->ipfs->key()->gen('mykey');
        $resultPublish = $this->ipfs->name()->publish($path = '/ipfs/'.$resultAdd['Hash'], '2s', 'mykey', true);
        $resultResolve = $this->ipfs->name()->resolve($resultPublish['Name']);

        $this->assertIsArray($resultResolve);
        $this->assertArrayHasKey('Path', $resultResolve);
        $this->assertEquals($path, $resultResolve['Path']);
    }
}
