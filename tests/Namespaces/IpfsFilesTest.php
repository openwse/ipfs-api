<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsFilesTest extends IpfsTestCase
{
    public function testItChangeCidVersion(): void
    {
        $resultChCid = $this->ipfs->files()->chcid('/');
        $this->assertIsArray($resultChCid);
    }

    public function testItCopy(): void
    {
        $resultAdd = $this->ipfs->add(__DIR__.'/../Fixtures/image.jpg');
        $this->assertIsArray($resultAdd);

        $cpResult = $this->ipfs->files()->cp('/ipfs/'.$resultAdd['Hash'], '/'.$resultAdd['Name']);
        $this->assertIsArray($cpResult);

        $this->testFiles[] = array_merge($resultAdd, ['_cp' => true, '_pin' => false]);
    }

    public function testItFlush(): void
    {
        $result = $this->ipfs->files()->flush();
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Cid', $result);
    }

    public function testItLs(): void
    {
        $imageOnIpfs = $this->ipfs->add(__DIR__.'/../Fixtures/image.jpg');
        $this->assertIsArray($imageOnIpfs);

        $cpResult = $this->ipfs->files()->cp('/ipfs/'.$imageOnIpfs['Hash'], '/'.$imageOnIpfs['Name']);
        $this->assertIsArray($cpResult);

        $this->testFiles[] = array_merge($imageOnIpfs, ['_cp' => true, '_pin' => false]);

        $result = $this->ipfs->files()->ls('/', true, true);
        $this->assertIsArray($result);
        $this->assertArrayHasKey('Entries', $result);
        $this->assertContains($imageOnIpfs['Name'], array_column($result['Entries'], 'Name'));
        $this->assertContains($imageOnIpfs['Hash'], array_column($result['Entries'], 'Hash'));
    }

    public function testItMakeDirectories(): void
    {
        $result = $this->ipfs->files()->mkdir('/test-dir/test-subdir', true);
        $this->assertIsArray($result);

        $resultLs = $this->ipfs->files()->ls('/', true);
        $this->assertIsArray($resultLs);
        $this->assertArrayHasKey('Entries', $resultLs);
        $this->assertContains('test-dir', array_column($resultLs['Entries'], 'Name'));

        $resultLsTestDir = $this->ipfs->files()->ls('/test-dir');
        $this->assertIsArray($resultLsTestDir);
        $this->assertArrayHasKey('Entries', $resultLsTestDir);
        $this->assertContains('test-subdir', array_column($resultLsTestDir['Entries'], 'Name'));

        $this->ipfs->files()->rm('/test-dir', true);
    }

    public function testItMv(): void
    {
        $text = 'This is my text for testing mv command.';
        $path = $this->writeFile($text, 'test.file.txt');

        $resultAdd = $this->ipfs->add($path);
        $this->assertIsArray($resultAdd);

        $cpResult = $this->ipfs->files()->cp('/ipfs/'.$resultAdd['Hash'], '/'.$resultAdd['Name']);
        $this->assertIsArray($cpResult);

        $resultMkdir = $this->ipfs->files()->mkdir('/test-dir-for-mv');
        $this->assertIsArray($resultMkdir);

        $resultMv = $this->ipfs->files()->mv('/'.$resultAdd['Name'], '/test-dir-for-mv/'.$resultAdd['Name']);
        $this->assertIsArray($resultMv);

        $resultLs = $this->ipfs->files()->ls('/test-dir-for-mv');
        $this->assertIsArray($resultLs);
        $this->assertArrayHasKey('Entries', $resultLs);
        $this->assertContains($resultAdd['Name'], array_column($resultLs['Entries'], 'Name'));

        $this->ipfs->files()->rm('/test-dir-for-mv', true);
        unlink($path);
    }

    public function testItReads(): void
    {
        $resultAdd = $this->addSample($text = 'Text for testing read command.');
        $this->assertIsArray($resultAdd);

        $resultRead = $this->ipfs->files()->read('/'.$resultAdd['Name']);
        $this->assertIsArray($resultRead);
        $this->assertArrayHasKey('Content', $resultRead);
        $this->assertEquals($text, $resultRead['Content']);
    }

    public function testItReadsStream(): void
    {
        $imageOnIpfs = $this->ipfs->add(__DIR__.'/../Fixtures/image.jpg');
        $this->assertIsArray($imageOnIpfs);

        $this->ipfs->files()->cp('/ipfs/'.$imageOnIpfs['Hash'], '/'.$imageOnIpfs['Name']);

        $resultRead = $this->ipfs->files()->read('/'.$imageOnIpfs['Name'], true);
        $this->assertIsArray($resultRead);
        $this->assertArrayHasKey('Content', $resultRead);

        $this->ipfs->files()->rm('/image.jpg', true);
    }

    public function testItRm(): void
    {
        $text = 'This is my text for testing rm command.';
        $path = $this->writeFile($text, 'test.file.to-be-removed.txt');

        $resultAdd = $this->ipfs->add($path);
        $this->assertIsArray($resultAdd);

        $cpResult = $this->ipfs->files()->cp('/ipfs/'.$resultAdd['Hash'], '/'.$resultAdd['Name']);
        $this->assertIsArray($cpResult);

        $resultRm = $this->ipfs->files()->rm('/'.$resultAdd['Name']);
        $this->assertIsArray($resultRm);

        unlink($path);
    }

    public function testItGetsStat(): void
    {
        $resultAdd = $this->addSample();
        $this->assertIsArray($resultAdd);

        $resultStat = $this->ipfs->files()->stat('/'.$resultAdd['Name']);
        $this->assertIsArray($resultStat);
        $this->assertArrayHasKey('Hash', $resultStat);
        $this->assertArrayHasKey('Size', $resultStat);
        $this->assertArrayHasKey('CumulativeSize', $resultStat);
        $this->assertArrayHasKey('Blocks', $resultStat);
        $this->assertArrayHasKey('Type', $resultStat);
    }
}
