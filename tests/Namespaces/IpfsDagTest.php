<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsDagTest extends IpfsTestCase
{
    public function testItExport(): void
    {
        $resultAdd = $this->addSample();
        $result = $this->ipfs->dag()->export($resultAdd['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Content', $result);
    }

    public function testItGet(): void
    {
        $resultAdd = $this->addSample();
        $result = $this->ipfs->dag()->get($resultAdd['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Content', $result);
    }

    public function testItImport(): void
    {
        $resultAdd = $this->addSample();
        $resultExport = $this->ipfs->dag()->export($resultAdd['Hash']);

        $file = $this->writeFile($resultExport['Content'], 'test.car');

        $result = $this->ipfs->dag()->import($file);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Root', $result);
        $this->assertArrayHasKey('Cid', $result['Root']);
        $this->assertArrayHasKey('PinErrorMsg', $result['Root']);
        $this->assertEmpty($result['Root']['PinErrorMsg']);

        unlink($file);
    }

    public function testItPut(): void
    {
        $file = $this->writeFile('{"key":"value"}', 'test.json');
        $result = $this->ipfs->dag()->put($file, 'cbor', 'json');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Cid', $result);

        unlink($file);
    }

    public function testItResolve(): void
    {
        $resultAdd = $this->addSample();
        $result = $this->ipfs->dag()->resolve('/ipfs/'.$resultAdd['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Cid', $result);
        $this->assertArrayHasKey('RemPath', $result);
    }

    public function testItGetsStats(): void
    {
        $resultAdd = $this->addSample();
        $result = $this->ipfs->dag()->stat($resultAdd['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Size', $result);
        $this->assertArrayHasKey('NumBlocks', $result);
    }
}
