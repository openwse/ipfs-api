<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsDiagTest extends IpfsTestCase
{
    public function testItGetsDiagSys(): void
    {
        $diagnostic = $this->ipfs->diag()->sys();

        $this->assertIsArray($diagnostic);
        $this->assertArrayHasKey('diskinfo', $diagnostic);
        $this->assertArrayHasKey('environment', $diagnostic);
        $this->assertArrayHasKey('net', $diagnostic);
    }

    public function testItGetsDiagCmds(): void
    {
        $cmds = $this->ipfs->diag()->cmds();

        $this->assertIsArray($cmds);
        $this->assertGreaterThan(1, count($cmds));
    }

    public function testItGetsDiagCmdsClear(): void
    {
        $cmdsClear = $this->ipfs->diag()->cmdsClear();

        $this->assertIsArray($cmdsClear);
    }

    public function testItGetsDiagCmdsSetTime(): void
    {
        $cmdsSetTime = $this->ipfs->diag()->cmdsSetTime(sprintf('%1$sm', 60 * 24));

        $this->assertIsArray($cmdsSetTime);
    }
}
