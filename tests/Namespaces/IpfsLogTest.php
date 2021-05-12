<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsLogTest extends IpfsTestCase
{
    public function testItChangeLogLevel(): void
    {
        $result = $this->ipfs->log()->level('all', $level = 'debug');
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Message', $result);
        $this->assertEquals("Changed log level of '*' to '".$level."'", trim($result['Message']));
    }

    public function testItLs(): void
    {
        $result = $this->ipfs->log()->ls();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Strings', $result);
    }
}
