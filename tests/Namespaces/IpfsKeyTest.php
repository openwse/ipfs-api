<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsKeyTest extends IpfsTestCase
{
    /**
     * As key/rotate, the ipfs daemon need to be shutdown to run this command.
     */
//    public function testItExport(): void
//    {
//        $this->ipfs->key()->gen($keyName = 'testkey');
//        $result = $this->ipfs->key()->export($keyName);
//    }

    public function testItGenerateANewPair(): void
    {
        $result = $this->ipfs->key()->gen($keyName = 'testkey', 'rsa', 2048);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Name', $result);
        $this->assertArrayHasKey('Id', $result);
        $this->assertEquals($keyName, $result['Name']);
    }

    public function testItList(): void
    {
        $result = $this->ipfs->key()->list(true);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Keys', $result);
        $this->assertEquals('self', $result['Keys'][0]['Name']);
    }

    public function testItRename(): void
    {
        $this->ipfs->key()->gen($keyName = 'testkey');
        $result = $this->ipfs->key()->rename($was = $keyName, $now = 'testnewname', true);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Was', $result);
        $this->assertArrayHasKey('Now', $result);
        $this->assertArrayHasKey('Id', $result);
        $this->assertArrayHasKey('Overwrite', $result);

        $this->assertEquals($was, $result['Was']);
        $this->assertEquals($now, $result['Now']);
    }

    public function testItRemove(): void
    {
        $this->ipfs->key()->gen($keyName = 'testkey');
        $result = $this->ipfs->key()->rm($keyName);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Keys', $result);
        $this->assertEquals($keyName, $result['Keys'][0]['Name']);
    }

    /*
     * Cannot test in docker without running an ephemeral container
     * @see: https://github.com/ipfs/go-ipfs/issues/7714
     * @see: https://github.com/ipfs/go-ipfs#key-rotation-inside-docker
     */
//    public function testItRotate(): void
//    {
//        $result = $this->ipfs->key()->rotate();
//    }
}
