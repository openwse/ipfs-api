<?php

namespace Ipfs\Tests;

use Ipfs\Drivers\HttpClient;
use Ipfs\Namespaces\Bitswap;
use Ipfs\Namespaces\Block;
use Ipfs\Namespaces\Bootstrap;
use Ipfs\Namespaces\Cid;
use Ipfs\Namespaces\Config;
use Ipfs\Namespaces\Dag;
use Ipfs\Namespaces\Dht;
use Ipfs\Namespaces\Diag;
use Ipfs\Namespaces\Files;
use Ipfs\Namespaces\Filestore;
use Ipfs\Namespaces\Key;
use Ipfs\Namespaces\Log;
use Ipfs\Namespaces\Name;
use Ipfs\Namespaces\Obj;
use Ipfs\Namespaces\P2P;
use Ipfs\Namespaces\Pin;
use Ipfs\Namespaces\Pubsub;
use Ipfs\Namespaces\Repo;
use Ipfs\Namespaces\Stats;
use Ipfs\Namespaces\Swarm;
use Ipfs\Namespaces\Tar;

class IpfsTest extends IpfsTestCase
{
    public function testIpfsClient(): void
    {
        $this->assertInstanceOf(HttpClient::class, $this->ipfs->getClient());
    }

    public function testItAddsFile(): void
    {
        $resultAdd = $this->addSample('This is my text for testing add command.', 'test.add.txt');

        $this->assertIsArray($resultAdd);
        $this->assertArrayHasKey('Name', $resultAdd);
        $this->assertArrayHasKey('Size', $resultAdd);
        $this->assertArrayHasKey('Hash', $resultAdd);
        $this->assertEquals('test.add.txt', $resultAdd['Name']);
    }

    public function testItAddsDirectory(): void
    {
        $directory = 'my-custom-dir-on-ipfs';
        $result = $this->ipfs->add($directory);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Name', $result);
        $this->assertArrayHasKey('Size', $result);
        $this->assertArrayHasKey('Hash', $result);
        $this->assertEquals($directory, $result['Name']);
    }

    public function testItAddsNestedFiles(): void
    {
        $path1 = $this->writeFile('Text file 1.', 'test.file1.txt');
        $path2 = $this->writeFile('Text file 2.', 'test.file2.txt');

        $files = [$path1, 'dir-for-file-2', [$path2, 'dir-for-file-2/test.file2.txt']];
        $result = $this->ipfs->add($files);
        $this->assertIsArray($result);
        $this->assertEquals(3, count($result));

        foreach ($files as $key => $file) {
            $name = (is_array($file)) ? $file[1] : basename($file);
            $this->ipfs->files()
                ->cp('/ipfs/'.$result[$key]['Hash'], '/'.$name)
            ;
        }

        $lsResult = $this->ipfs->files()->ls('/', true, true);
        $this->assertIsArray($lsResult);
        $this->assertEquals('dir-for-file-2', $lsResult['Entries'][0]['Name']);
        $this->assertEquals('test.file1.txt', $lsResult['Entries'][1]['Name']);

        $lsResultDir = $this->ipfs->files()->ls('/dir-for-file-2', true, true);
        $this->assertIsArray($lsResultDir);
        $this->assertEquals('test.file2.txt', $lsResultDir['Entries'][0]['Name']);

        $this->ipfs->files()->rm('/dir-for-file-2', true);
        $this->ipfs->files()->rm('/test.file1.txt', true);

        unlink($path1);
        unlink($path2);
    }

    public function testItCats(): void
    {
        $resultAdd = $this->addSample($text = 'This is my text for testing cat command.');
        $this->assertIsArray($resultAdd);

        $catResult = $this->ipfs->cat('/ipfs/'.$resultAdd['Hash']);
        $this->assertIsArray($catResult);
        $this->assertArrayHasKey('Content', $catResult);
        $this->assertEquals($text, $catResult['Content']);
    }

    public function testItGetsCommands(): void
    {
        $commands = $this->ipfs->commands();

        $this->assertIsArray($commands);
        $this->assertArrayHasKey('Name', $commands);
        $this->assertArrayHasKey('Subcommands', $commands);
    }

    public function testItGetsDns(): void
    {
        $result = $this->ipfs->dns('ipfs.io');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Path', $result);
    }

    public function testItGets(): void
    {
        $resultAdd = $this->addSample($text = 'This is my text for testing get command.');
        $this->assertIsArray($resultAdd);

        $getResult = $this->ipfs->get('/ipfs/'.$resultAdd['Hash'], false, true, 9);
        $this->assertIsArray($getResult);
        $this->assertArrayHasKey('Content', $getResult);
        $this->assertEquals($text, gzdecode($getResult['Content']));
    }

    public function testItGetsId(): void
    {
        $id = $this->ipfs->id();

        $this->assertIsArray($id);
        $this->assertArrayHasKey('ID', $id);
        $this->assertArrayHasKey('PublicKey', $id);
        $this->assertArrayHasKey('Addresses', $id);
    }

    public function testItLs(): void
    {
        $resultAdd = $this->addSample();
        $this->assertIsArray($resultAdd);

        $path = '/ipfs/'.$resultAdd['Hash'];
        $lsResult = $this->ipfs->ls($path);
        $this->assertIsArray($lsResult);
        $this->assertArrayHasKey('Objects', $lsResult);
        $this->assertEquals($path, $lsResult['Objects'][0]['Hash']);
    }

    public function testItGetsVersion(): void
    {
        $version = $this->ipfs->version();

        $this->assertIsArray($version);
        $this->assertArrayHasKey('Version', $version);
        $this->assertArrayHasKey('Commit', $version);
        $this->assertArrayHasKey('System', $version);
    }

    public function ipfsNamespaces(): iterable
    {
        yield [Bitswap::class, 'bitswap'];
        yield [Block::class, 'block'];
        yield [Bootstrap::class, 'bootstrap'];
        yield [Cid::class, 'cid'];
        yield [Config::class, 'config'];
        yield [Dag::class, 'dag'];
        yield [Dht::class, 'dht'];
        yield [Diag::class, 'diag'];
        yield [Files::class, 'files'];
        yield [Filestore::class, 'filestore'];
        yield [Key::class, 'key'];
        yield [Log::class, 'log'];
        yield [Name::class, 'name'];
        yield [Obj::class, 'object'];
        yield [P2P::class, 'p2p'];
        yield [Pin::class, 'pin'];
        yield [Pubsub::class, 'pubsub'];
        yield [Repo::class, 'repo'];
        yield [Stats::class, 'stats'];
        yield [Swarm::class, 'swarm'];
        yield [Tar::class, 'tar'];
    }

    /**
     * @dataProvider ipfsNamespaces
     */
    public function testItGetsNamespaces(string $classNamespace, string $methodNamespace): void
    {
        /* @phpstan-ignore-next-line */
        $this->assertInstanceOf($classNamespace, $this->ipfs->{$methodNamespace}());
    }
}
