<?php

namespace Ipfs;

use RuntimeException;

final class IpfsException extends RuntimeException
{
    public static function makeFromResponse(string $response): IpfsException
    {
        $error = json_decode($response, true);

        return new IpfsException($error['Message'], $error['Code']);
    }
}
