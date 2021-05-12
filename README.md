## A minimal implementation of IPFS API

```php
$client = new Ipfs\Ipfs(
    new Ipfs\Drivers\HttpClient('https://ipfs-host', 5001)
);

// add a single file (and pin it)
$client->add('/path/to/the/file', true);

// add a nested structure
$client->add([
    '/path/to/local/file' => '/path/on/ipfs',
    'my-custom-dir',
    '/path/file' => '/my-custom-dir/filename', 
]);

// list all files
$client->files()->ls();

// get the version
$client->version();
```

#### TODOS:

- [] Stream supports
- [] Implement the following endpoints:
    - [] Bitswap 
    - [] Block 
    - [] Bootstrap 
    - [] Dag 
    - [] Dht 
    - [] Filestore 
    - [] Key 
    - [] Name 
    - [] Object 
    - [] P2P 
    - [] Pubsub 
    - [] Repo 
    - [] Tar 
