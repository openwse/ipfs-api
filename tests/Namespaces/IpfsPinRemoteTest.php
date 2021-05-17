<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Namespaces\PinRemote;
use Ipfs\Tests\IpfsTestCase;

class IpfsPinRemoteTest extends IpfsTestCase
{
    public function testItAdd(): void
    {
        $this->ipfs->pin()->service()->add($service = 'Pinata', 'https://api.pinata.cloud/psa', $_ENV['PINATA_TOKEN']);

        $resultAdd = $this->addSample();
        $this->assertIsArray($resultAdd);

        $result = $this->ipfs->pin()->remote($service)->add($resultAdd['Hash'], $fileName = 'test-meta.txt', true);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Status', $result);
        $this->assertArrayHasKey('Cid', $result);
        $this->assertArrayHasKey('Name', $result);
        $this->assertEquals($resultAdd['Hash'], $result['Cid']);
        $this->assertEquals($fileName, $result['Name']);

        $this->ipfs->pin()->remote($service)->rm([$resultAdd['Hash']], null, PinRemote::ALL_STATUSES, true);
        sleep(2);
    }

    public function testItLs(): void
    {
        $this->ipfs->pin()->service()->add($service = 'Pinata', 'https://api.pinata.cloud/psa', $_ENV['PINATA_TOKEN']);

        $resultAdd = $this->addSample('My text', $fileName = 'test-pinata.txt');
        $this->assertIsArray($resultAdd);

        $this->ipfs->pin()->remote($service)->add($resultAdd['Hash'], $fileName, true, [
            'meta_key' => 'meta_value',
        ]);
        sleep(2);

        $result = $this->ipfs->pin()->remote($service)->ls(null, null, PinRemote::ALL_STATUSES);
        $object = (isset($result['Status'])) ? $result : $result[0];

        $this->assertIsArray($object);
        $this->assertArrayHasKey('Status', $object);
        $this->assertArrayHasKey('Cid', $object);
        $this->assertArrayHasKey('Name', $object);
        $this->assertEquals($fileName, $object['Name']);

        $this->ipfs->pin()->remote($service)->rm([$resultAdd['Hash']], null, PinRemote::ALL_STATUSES, true);
        sleep(2);
    }

    public function testItRm(): void
    {
        $this->ipfs->pin()->service()->add($service = 'Pinata', 'https://api.pinata.cloud/psa', $_ENV['PINATA_TOKEN']);

        $resultAdd = $this->addSample('My text', $fileName = 'test-pinata.txt');
        $this->assertIsArray($resultAdd);

        $this->ipfs->pin()->remote($service)->add($resultAdd['Hash'], $fileName);
        sleep(2);

        $result = $this->ipfs->pin()->remote($service)->rm([$resultAdd['Hash']], null, PinRemote::ALL_STATUSES, true);
        $this->assertIsArray($result);

        $resultLs = $this->ipfs->pin()->remote($service)->ls(null, null, PinRemote::ALL_STATUSES);
        $this->assertIsArray($resultLs);

        if (! empty($resultLs)) {
            $object = (isset($resultLs['Status'])) ? $resultLs : $resultLs[0];
            $this->assertNotContains($resultAdd['Hash'], array_values($object));
        }
    }
}
