<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsBlockTest extends IpfsTestCase
{
    public function testItGet(): void
    {
        $resultAdd = $this->addSample('contents');
        $this->assertIsArray($resultAdd);

        $result = $this->ipfs->block()->get($resultAdd['Hash']);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Content', $result);
        $this->assertStringContainsString('contents', $result['Content']);
    }

    public function testItRm(): void
    {
        $resultAdd = $this->addSample('my content', 'test-content.txt');
        $this->assertIsArray($resultAdd);

        $result = $this->ipfs->block()->rm($resultAdd['Hash']);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Hash', $result);
        $this->assertEquals($resultAdd['Hash'], $result['Hash']);
    }

    public function testItGetsStats(): void
    {
        $resultAdd = $this->addSample('contents');
        $this->assertIsArray($resultAdd);

        $result = $this->ipfs->block()->stat($resultAdd['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Key', $result);
        $this->assertArrayHasKey('Size', $result);
        $this->assertEquals($resultAdd['Hash'], $result['Key']);
        $this->assertEquals(16, $result['Size']);
    }
}
