<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsObjTest extends IpfsTestCase
{
    public function testItOutputData(): void
    {
        $resultAdd = $this->addSample();
        $result = $this->ipfs->object()->data($resultAdd['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Content', $result);
    }

    public function testItDiff(): void
    {
        $resultAdd1 = $this->addSample('text for content 1', 'test1.file.txt');
        $resultAdd2 = $this->addSample('text for testing diff', 'test2.file.txt');
        $result = $this->ipfs->object()->diff($resultAdd1['Hash'], $resultAdd2['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Changes', $result);
        $this->assertArrayHasKey('Before', $result['Changes'][0]);
        $this->assertArrayHasKey('After', $result['Changes'][0]);
    }

    public function testItGet(): void
    {
        $resultAdd = $this->addSample();
        $result = $this->ipfs->object()->get($resultAdd['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Links', $result);
        $this->assertArrayHasKey('Data', $result);
    }

    public function testItGetLinks(): void
    {
        $resultAdd = $this->addSample();
        $result = $this->ipfs->object()->links($resultAdd['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Hash', $result);
    }

    public function testItCreateNew(): void
    {
        $result = $this->ipfs->object()->new();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Hash', $result);
    }

    public function testItPatchAddLink(): void
    {
        $object1 = $this->ipfs->object()->new();
        $object2 = $this->addSample();

        $result = $this->ipfs->object()->patchAddLink($object1['Hash'], $linkName = 'mylink', $object2['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Hash', $result);

        $links = $this->ipfs->object()->links($result['Hash']);
        $this->assertIsArray($links);
        $this->assertEquals($linkName, $links['Links'][0]['Name']);
    }

    public function testItPatchAppendData(): void
    {
        $object = $this->ipfs->object()->new();

        $data1 = $this->writeFile($content1 = 'contents', 'test1.file.txt');
        $result1 = $this->ipfs->object()->patchAppendData($data1, $object['Hash']);

        $data2 = $this->writeFile($content2 = 'append data', 'test2.file.txt');
        $result2 = $this->ipfs->object()->patchAppendData($data2, $result1['Hash']);

        $this->assertIsArray($result2);
        $this->assertArrayHasKey('Hash', $result2);

        $resultGet = $this->ipfs->object()->get($result2['Hash']);
        $this->assertEquals($content1.$content2, $resultGet['Data']);

        unlink($data1);
        unlink($data2);
    }

    public function testItPatchRmLink(): void
    {
        $object = $this->ipfs->object()->new();
        $object2 = $this->addSample('contents', 'test2.file.txt');
        $object3 = $this->addSample('contents', 'test3.file.txt');

        $res1 = $this->ipfs->object()->patchAddLink($object['Hash'], $linkName1 = 'mylink1', $object2['Hash']);
        $res2 = $this->ipfs->object()->patchAddLink($res1['Hash'], $linkName2 = 'mylink2', $object3['Hash']);

        $linksBefore = $this->ipfs->object()->links($res2['Hash']);
        $this->assertIsArray($linksBefore);
        $this->assertEquals(2, count($linksBefore['Links']));
        $this->assertEquals($linkName1, $linksBefore['Links'][0]['Name']);

        $resultRm = $this->ipfs->object()->patchRmLink($res2['Hash'], $linkName1);
        $this->assertIsArray($resultRm);

        $linksAfter = $this->ipfs->object()->links($resultRm['Hash']);
        $this->assertIsArray($linksAfter);
        $this->assertEquals(1, count($linksAfter['Links']));
        $this->assertEquals($linkName2, $linksAfter['Links'][0]['Name']);
    }

    public function testItPatchSetData(): void
    {
        $object = $this->ipfs->object()->new();
        $data = $this->writeFile($content = 'contents', 'test.file.txt');
        $result = $this->ipfs->object()->patchSetData($data, $object['Hash']);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Hash', $result);

        $resultGet = $this->ipfs->object()->get($result['Hash']);
        $this->assertEquals($content, $resultGet['Data']);

        unlink($data);
    }

    public function testItPut(): void
    {
        $file = $this->writeFile('{"Links": [], "Data": "contents"}', 'test.json');
        $result = $this->ipfs->object()->put($file, 'json', 'text');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Hash', $result);

        $resultGet = $this->ipfs->object()->get($result['Hash']);
        $this->assertEquals('contents', $resultGet['Data']);

        unlink($file);
    }

    public function testItGetsStats(): void
    {
        $file = $this->writeFile('{"Links": [], "Data": "contents"}', 'test.json');
        $resultPut = $this->ipfs->object()->put($file, 'json', 'text');

        $result = $this->ipfs->object()->stat($resultPut['Hash'], true);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Hash', $result);
        $this->assertArrayHasKey('NumLinks', $result);
        $this->assertArrayHasKey('BlockSize', $result);
        $this->assertArrayHasKey('LinksSize', $result);
        $this->assertArrayHasKey('DataSize', $result);
        $this->assertArrayHasKey('CumulativeSize', $result);

        unlink($file);
    }
}
