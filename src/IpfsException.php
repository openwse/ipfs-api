<?php

namespace Ipfs;

use Psr\Http\Message\ResponseInterface;
use RuntimeException;

final class IpfsException extends RuntimeException
{
    public static function makeFromResponse(ResponseInterface $response): IpfsException
    {
        $contents = $response->getBody()->getContents();

        $error = (! empty($contents))
            ? json_decode($contents, true) ?? ['Message' => $contents, 'Code' => $response->getStatusCode()]
            : ['Message' => $response->getReasonPhrase(), 'Code' => $response->getStatusCode()]
        ;

        return new IpfsException($error['Message'], $error['Code']);
    }
}
