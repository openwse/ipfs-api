<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\IpfsException;
use Ipfs\Tests\IpfsTestCase;

// TODO: Setup a node with filestore enabled
class IpfsFilestoreTest extends IpfsTestCase
{
    public function testItFindDuplicates(): void
    {
        $fileStoreEnabled = $this->ipfs->config()->get('Experimental.FilestoreEnabled');

        if ($fileStoreEnabled['Value'] === false) {
            $this->expectException(IpfsException::class);
            $this->expectExceptionMessage('filestore is not enabled');
        }

        $result = $this->ipfs->filestore()->dups();
    }
}
