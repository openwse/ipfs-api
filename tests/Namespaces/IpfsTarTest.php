<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsTarTest extends IpfsTestCase
{
    public function testItAdd(): void
    {
        $archive = $this->createArchive('add.tar');
        $result = $this->ipfs->tar()->add($archive->getPath());
        unlink($archive->getPath());

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Name', $result);
        $this->assertArrayHasKey('Hash', $result);
    }

    public function testItCat(): void
    {
        $archive = $this->createArchive('ipfs-archive.tar');
        $resultAdd = $this->ipfs->tar()->add($archive->getPath());
        unlink($archive->getPath());

        $result = $this->ipfs->tar()->cat('/ipfs/'.$resultAdd['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Content', $result);
    }

    private function createArchive(string $name = 'archive.tar'): \PharData
    {
        $archive = new \PharData($name);
        $archive->addFromString('test.txt', 'contents');
        $archive->addEmptyDir('some');
        $archive->addFromString('some/myfile.txt', 'My awesome content');

        return $archive;
    }
}
