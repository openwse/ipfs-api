<?php

namespace Ipfs\Tests\Namespaces;

use Ipfs\Tests\IpfsTestCase;

class IpfsCidTest extends IpfsTestCase
{
    public function validCidHashes(): iterable
    {
        yield ['QmYbsv7VDUEx2ihYLLFQU77A4RRwx79JxoeAfc8yaXpnip'];
        yield ['QmckApdQjJhPAkmoSqe7GEpk2VwvNfJ5W2kRwu4pPuSVAq'];
        yield ['Qmb9LRL2aSHQ2qvQx5aE6bghG8WcYMzpzuYTU5pxL1epAw'];
        yield ['QmeHiaUTRQxmqciCLxwtdGFt8tA7BzfHT1APekL1jT4spF'];
        yield ['QmRw3mteq2PyCstoNcweEFj7oH8aD1wjYX67Yc4xVSjvPY'];
    }

    public function cidConversions(): iterable
    {
        yield ['QmYbsv7VDUEx2ihYLLFQU77A4RRwx79JxoeAfc8yaXpnip', null, '1', 'eth-block', 'base16'];
        yield ['QmckApdQjJhPAkmoSqe7GEpk2VwvNfJ5W2kRwu4pPuSVAq', null, '1', 'dash-tx', 'base36'];
        yield ['Qmb9LRL2aSHQ2qvQx5aE6bghG8WcYMzpzuYTU5pxL1epAw', null, '1', 'raw', 'base32upper'];
        yield ['QmeHiaUTRQxmqciCLxwtdGFt8tA7BzfHT1APekL1jT4spF', null, '1', 'zcash-tx', 'base64'];
        yield ['QmRw3mteq2PyCstoNcweEFj7oH8aD1wjYX67Yc4xVSjvPY', null, '1', 'protobuf', 'identity'];
    }

    /**
     * @dataProvider validCidHashes
     */
    public function testItConvertsToBase32(string $hash): void
    {
        $cidBase32 = $this->ipfs->cid()->base32($hash);

        $this->assertIsArray($cidBase32);
        $this->assertArrayHasKey('CidStr', $cidBase32);
        $this->assertArrayHasKey('Formatted', $cidBase32);
        $this->assertArrayHasKey('ErrorMsg', $cidBase32);
        $this->assertEquals($hash, $cidBase32['CidStr']);
        $this->assertEmpty($cidBase32['ErrorMsg']);
    }

    public function testItGetsCidBases(): void
    {
        $cidBases = $this->ipfs->cid()->bases();

        $this->assertIsArray($cidBases);
        $this->assertGreaterThan(1, count($cidBases));
    }

    public function testItGetsCidCodecs(): void
    {
        $cidCodecs = $this->ipfs->cid()->codecs();

        $this->assertIsArray($cidCodecs);
        $this->assertGreaterThan(1, count($cidCodecs));
    }

    /**
     * @dataProvider cidConversions
     */
    public function testItFormatAndConvertACid(string $hash, ?string $format, ?string $version, ?string $codec, ?string $base): void
    {
        $cidConverted = $this->ipfs->cid()->format($hash, $format, $version, $codec, $base);

        $this->assertIsArray($cidConverted);
        $this->assertArrayHasKey('CidStr', $cidConverted);
        $this->assertArrayHasKey('Formatted', $cidConverted);
        $this->assertArrayHasKey('ErrorMsg', $cidConverted);
        $this->assertEquals($hash, $cidConverted['CidStr']);
        $this->assertEmpty($cidConverted['ErrorMsg']);
    }

    public function testItGetsCidHashes(): void
    {
        $cidHashes = $this->ipfs->cid()->hashes();

        $this->assertIsArray($cidHashes);
        $this->assertGreaterThan(1, count($cidHashes));
    }
}
