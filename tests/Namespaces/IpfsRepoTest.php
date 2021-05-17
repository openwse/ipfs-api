<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\IpfsException;
use Ipfs\Tests\IpfsTestCase;

class IpfsRepoTest extends IpfsTestCase
{
    public function testItCallFsck(): void
    {
        // `ipfs repo fsck` is deprecated and does nothing.
        $this->expectException(IpfsException::class);
        $this->expectExceptionMessage('404 page not found');
        $this->ipfs->repo()->fsck();
    }

//    public function testItCallGc(): void
//    {
//        $result = $this->ipfs->repo()->gc(false, false);
//        $this->assertIsArray($result);
//    }

    public function testItGetsStats(): void
    {
        $result = $this->ipfs->repo()->stat(false, true);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('RepoSize', $result);
        $this->assertArrayHasKey('StorageMax', $result);
        $this->assertArrayHasKey('NumObjects', $result);
        $this->assertArrayHasKey('RepoPath', $result);
        $this->assertArrayHasKey('Version', $result);
    }

    public function testItVerify(): void
    {
        $result = $this->ipfs->repo()->verify();

        $this->assertIsArray($result);
        $this->assertGreaterThanOrEqual(1, count($result));
        $lastMsg = array_pop($result);
        $this->assertEquals('verify complete, all blocks validated.', $lastMsg['Msg']);
    }

    public function testItGetsVersion(): void
    {
        $result = $this->ipfs->repo()->version();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Version', $result);
    }
}
