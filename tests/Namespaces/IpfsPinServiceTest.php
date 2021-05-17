<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsPinServiceTest extends IpfsTestCase
{
    public function testItAddService(): void
    {
        $this->ipfs->pin()->service()->add($name = 'Pinata', $endpoint = 'https://api.pinata.cloud/psa', $_ENV['PINATA_TOKEN']);
        // $this->ipfs->config()->set('Pinning.RemoteServices.Pinata.Policies.MFS.Enable', true, true);

        $lsResult = $this->ipfs->pin()->service()->ls();

        $this->assertIsArray($lsResult);
        $this->assertArrayHasKey('RemoteServices', $lsResult);
        $this->assertEquals($name, $lsResult['RemoteServices'][0]['Service']);
        $this->assertEquals($endpoint, $lsResult['RemoteServices'][0]['ApiEndpoint']);
    }

    public function testItLsServices(): void
    {
        $result = $this->ipfs->pin()->service()->ls();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('RemoteServices', $result);
    }

    public function testItRmService(): void
    {
        $this->ipfs->pin()->service()->add($name = 'Pinata', 'https://api.pinata.cloud/psa', $_ENV['PINATA_TOKEN']);

        $this->ipfs->pin()->service()->rm($name);

        $lsResult = $this->ipfs->pin()->service()->ls();
        $this->assertIsArray($lsResult);
        $this->assertEquals(0, count($lsResult['RemoteServices']));
    }
}
