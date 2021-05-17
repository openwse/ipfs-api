## A minimal implementation of IPFS API



## Installation
You can install the package via composer:

``` bash
composer require openwse/ipfs-api
```


## Usage
```php
$client = new Ipfs\Ipfs(
    new Ipfs\Drivers\HttpClient('https://ipfs-host', 5001)
);

// add a single file (and pin it)
$client->add('/path/to/the/file', true);

// add a file from content
$client->add([
    ['/desired-path-on-ipfs/filename.txt', null, 'my text content', 'text/plain']
]);

// add a nested structure
$client->add([
    ['/path/to/local/file', '/path/on/ipfs'],
    'my-custom-dir',
    ['/path/to/local/file', '/my-custom-dir/filename'],
]);

// list all files
$client->files()->ls();

// get the version
$client->version();

// publish
$client->key()->gen('mykeyname');
$client->name()->publish('/path/hash', '48h', 'mykeyname');


// some other examples...
$client->cat('/path/hash');

$client->config()->set('key', 'value');

$client->pin()->add('/path/hash');

$client->pin()->verify();

$client->stats()->bw();

$client->key()->rm('mykeyname');
```


## Lint
Run [PHPMD](https://phpmd.org/), [PHPStan](https://phpstan.org/), and [PHP-CS-Fixer](https://github.com/FriendsOfPhp/PHP-CS-Fixer)
``` bash
composer lint
```


## Testing
``` bash
composer tests
```


## TODOS:
- Complete async/streams requests
- Implement the following endpoints:
    - P2P 
    - Pubsub (with name/pubsub/{cancel,state,subs})
- Missing tests:
    - Block > put
    - Filestore
    - Dht


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

