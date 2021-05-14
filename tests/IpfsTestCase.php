<?php

namespace Ipfs\Tests;

use Ipfs\Drivers\HttpClient;
use Ipfs\Ipfs;
use PHPUnit\Framework\TestCase;

class IpfsTestCase extends TestCase
{
    protected Ipfs $ipfs;

    protected array $testFiles = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->ipfs = new Ipfs(
            new HttpClient('http://ipfs', 5001)
        );
    }

    public function tearDown(): void
    {
        foreach ($this->testFiles as $testFile) {
            if ($testFile['_pin']) {
                $this->ipfs->pin()->rm('/ipfs/'.$testFile['Hash']);
            }

            if ($testFile['_cp']) {
                $this->ipfs->files()->rm('/'.$testFile['Name']);
            }

            if (isset($testFile['_delete_local']) && $testFile['_delete_local']) {
                unlink(__DIR__.'/Fixtures/'.$testFile['Name']);
            }
        }

        $this->ipfs->files()->flush();

        foreach (array_column($this->ipfs->key()->list()['Keys'], 'Name') as $key) {
            if ($key !== 'self') {
                $this->ipfs->key()->rm($key);
            }
        }

        parent::tearDown();
    }

    public function addSample(string $content = 'Text for testing.', string $filename = 'test.file.txt', bool $pin = false, bool $cp = true): array
    {
        $file = $this->writeFile($content, $filename);
        $resultAdd = $this->ipfs->add($file, $pin);
        $testFile = ['Name', $filename, '_delete_local' => true];

        if (is_array($resultAdd) && isset($resultAdd['Hash'])) {
            $testFile = array_merge($testFile, $resultAdd, ['_pin' => $pin]);
        }

        if ($cp === true) {
            $this->ipfs->files()->cp('/ipfs/'.$resultAdd['Hash'], '/'.$resultAdd['Name']);
            $testFile = array_merge($testFile, ['_cp' => $cp]);
        }

        $this->testFiles[] = $testFile;

        return $resultAdd;
    }

    public function writeFile(string $content, string $filename): string
    {
        $path = __DIR__.'/Fixtures/'.$filename;

        file_put_contents($path, $content);
        chmod($path, 0755);

        return $path;
    }
}
