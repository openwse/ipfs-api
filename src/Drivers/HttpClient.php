<?php

namespace Ipfs\Drivers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Ipfs\Contracts\IpfsClient;
use Ipfs\IpfsException;

class HttpClient implements IpfsClient
{
    private string $host;

    private int $port;

    private Client $http;

    private Request $request;

    private array $requestOptions;

    public function __construct(string $host, int $port, array $options = [])
    {
        $this->host = $host;
        $this->port = $port;
        $this->http = new Client(array_merge_recursive([
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::TIMEOUT => 3.0,
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
            ],
        ], $options));
        $this->requestOptions = [];
    }

    public function request(string $url, array $payload = []): IpfsClient
    {
        $path = $this->buildQuery($url, $payload);

        $this->request = new Request('POST', "{$this->host}:{$this->port}/api/v0/{$path}");

        return $this;
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function send(array $options = []): array
    {
        $response = $this->http->send($this->request, array_merge_recursive($this->requestOptions, $options));
        $this->requestOptions = [];

        if ($response->getStatusCode() !== 200) {
            throw IpfsException::makeFromResponse($response->getBody()->getContents());
        }

        $contents = $response->getBody()->getContents();
        if (empty($contents)) {
            return [];
        }

        if (current($response->getHeader('Content-Type')) === 'application/json') {
            return json_decode($contents, true) ?? $this->parse($contents);
        }

        return ['Content' => $contents];
    }

    /**
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function attach(string $fileOrDir, ?string $name = null): IpfsClient
    {
        $attached = [];

        if (is_file($fileOrDir)) {
            $content = file_get_contents($fileOrDir);
            if ($content === false) {
                $error = error_get_last();
                throw new IpfsException($error ? $error['message'] : 'Unexpected error while getting file content of '.$fileOrDir);
            }

            /** @var resource $mimeFlag */
            $mimeFlag = finfo_open(FILEINFO_MIME_TYPE);
            array_push($attached, [
                'name' => 'file',
                'contents' => $content,
                'headers' => [
                    'Content-Type' => finfo_file($mimeFlag, $fileOrDir),
                ],
                'filename' => $name ?? basename($fileOrDir),
            ]);
        } else {
            array_push($attached, [
                'name' => 'file',
                'contents' => 'directory',
                'headers' => [
                    'Content-Type' => 'application/x-directory',
                ],
                'filename' => $fileOrDir,
            ]);
        }

        if (! empty($attached)) {
            $this->requestOptions = array_merge_recursive($this->requestOptions, [
                RequestOptions::MULTIPART => $attached,
            ]);
        }

        return $this;
    }

    protected function parse(string $str): array
    {
        // RPC-style API
        // @see https://docs.ipfs.io/reference/http/api/#getting-started
        $parsed = preg_replace('/}/', '},', $str);
        if (! is_string($parsed)) {
            throw new IpfsException(preg_last_error_msg());
        }

        return json_decode('['.substr(trim($parsed), 0, -1).']', true);
    }

    protected function buildQuery(string $path, array $data = []): string
    {
        if (! empty($data)) {
            $params = array_map([$this, 'formatValue'], array_filter($data, function ($datum, $key) {
                return $key !== 'args' && ! is_null($datum);
            }, ARRAY_FILTER_USE_BOTH));

            $args = (isset($data['args'])) ? implode('&', array_map(function ($arg) {
                return sprintf('arg=%1$s', $this->formatValue($arg));
            }, $data['args'])) : '';

            $query = (! empty($args)) ? $args.'&' : '';
            $query .= (! empty($params)) ? http_build_query($params) : '';

            if (! empty($query)) {
                $path .= '?'.trim($query, '&');
            }
        }

        return $path;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function formatValue($value)
    {
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        return $value;
    }
}
