<?php

namespace Ipfs\Namespaces;

use Ipfs\IpfsNamespace;

class Obj extends IpfsNamespace
{
    /**
     * Output the raw bytes of an IPFS object.
     */
    public function data(string $key): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/data', [
            'arg' => $key,
        ])->send();
    }

    /**
     * Display the diff between two IPFS objects.
     */
    public function diff(string $diffAgainst, string $diff): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/diff', [
            'arg' => [
                $diffAgainst,
                $diff,
            ],
        ])->send();
    }

    /**
     * Get and serialize the DAG node named by <key>.
     * Data encoding is one of: text, base64.
     */
    public function get(string $key, string $dataEncoding = 'text'): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/get', [
            'arg' => $key,
            'data-encoding' => $dataEncoding,
        ])->send();
    }

    /**
     * Output the links pointed to by the specified object.
     */
    public function links(string $key, ?bool $headers = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/links', [
            'arg' => $key,
            'headers' => $headers,
        ])->send();
    }

    /**
     * Create a new object from an IPFS template.
     */
    public function new(?string $template = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/new', [
            'arg' => $template,
        ])->send();
    }

    /**
     * Add a link to a given object.
     */
    public function patchAddLink(string $hash, string $linkName, string $object, ?bool $create = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/patch/add-link', [
            'arg' => [
                $hash,
                $linkName,
                $object,
            ],
            'create' => $create,
        ])->send();
    }

    /**
     * Append data to the data segment of a DAG node.
     */
    public function patchAppendData(string $data, string $hash): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/patch/append-data', [
            'arg' => $hash,
        ])->attach($data)->send();
    }

    /**
     * Append data to the data segment of a DAG node.
     */
    public function patchRmLink(string $hash, string $linkName): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/patch/rm-link', [
            'arg' => [
                $hash,
                $linkName,
            ],
        ])->send();
    }

    /**
     * Set the data field of an IPFS object.
     */
    public function patchSetData(string $data, string $hash): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/patch/set-data', [
            'arg' => $hash,
        ])->attach($data)->send();
    }

    /**
     * Store input as a DAG object, print its key.
     *
     * Input encoding must be one of: protobuf, json
     * Data field encoding must be one of: text, base64
     */
    public function put(string $data, string $inputEncoding, string $dataFieldEncoding, ?bool $pin = null, ?bool $quiet = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/put', [
            'inputenc' => $inputEncoding,
            'datafieldenc' => $dataFieldEncoding,
            'pin' => $pin,
            'quiet' => $quiet,
        ])->attach($data)->send();
    }

    /**
     * Get stats for the DAG node named by <key>.
     */
    public function stat(string $hash, ?bool $human = null): array
    {
        /* @phpstan-ignore-next-line */
        return $this->client->request('object/stat', [
            'arg' => $hash,
            'human' => $human,
        ])->send();
    }
}
