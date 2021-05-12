<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\IpfsException;
use Ipfs\Tests\IpfsTestCase;

class IpfsPinTest extends IpfsTestCase
{
    public function testItAdds(): void
    {
        $resultAdd = $this->addSample();
        $this->assertIsArray($resultAdd);

        $result = $this->ipfs->pin()->add($resultAdd['Hash']);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Pins', $result);
    }

    public function testItLs(): void
    {
        $resultAdd = $this->addSample();
        $this->assertIsArray($resultAdd);

        $result = $this->ipfs->pin()->ls($resultAdd['Hash']);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Keys', $result);
    }

    public function testItRm(): void
    {
        $resultAdd = $this->addSample();
        $this->assertIsArray($resultAdd);

        $result = $this->ipfs->pin()->add($resultAdd['Hash']);
        $this->assertIsArray($result);

        $resultRm = $this->ipfs->pin()->rm($resultAdd['Hash']);
        $this->assertIsArray($resultRm);

        $this->expectException('Ipfs\IpfsException');
        $this->expectExceptionMessage("path '".$resultAdd['Hash']."' is not pinned");
        $this->ipfs->pin()->ls($resultAdd['Hash']);
    }

    public function testItUpdates(): void
    {
        $resultAdd1 = $this->addSample('test for content 1', 'test-file-1.txt');
        $this->assertIsArray($resultAdd1);
        $this->ipfs->pin()->add($resultAdd1['Hash']);

        $resultAdd2 = $this->addSample('test random string', 'test-file-2.txt');
        $this->assertIsArray($resultAdd2);

        $this->ipfs->pin()->update($resultAdd1['Hash'], $resultAdd2['Hash']);

        try {
            $this->ipfs->pin()->ls($resultAdd1['Hash']);
        } catch (IpfsException $exception) {
            $this->assertEquals("path '".$resultAdd1['Hash']."' is not pinned", trim($exception->getMessage()));
        }

        $resultLs = $this->ipfs->pin()->ls($resultAdd2['Hash']);
        $this->assertIsArray($resultLs);
        $this->assertArrayHasKey('Keys', $resultLs);
        $this->assertEquals(1, count($resultLs['Keys']));
        $this->assertArrayHasKey($resultAdd2['Hash'], $resultLs['Keys']);

        $this->ipfs->pin()->rm($resultAdd2['Hash']);
    }

    public function testItVerifies(): void
    {
        $resultAdd = $this->addSample();
        $this->assertIsArray($resultAdd);

        $resultAddPin = $this->ipfs->pin()->add($resultAdd['Hash']);
        $this->assertIsArray($resultAddPin);

        $result = $this->ipfs->pin()->verify();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Cid', $result);
        $this->assertArrayHasKey('Ok', $result);
        $this->assertTrue($result['Ok']);
    }
}
