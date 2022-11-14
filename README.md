
# ThePower.io SDK for PHP

Production ready SDK for ThePower.io API


## Installation

### Install via composer

```bash
  composer require arthurpatriot/thepower-sdk
```

### Create new API Client

```php
use ThePower\PowerClient;

$client = new PowerClient('{NODE_URL}');
```

Example, `{NODE_URL}` is `https://power-node.allsteeply.com:1443`.
    
## Usage

### Get Status

```php
$client->status();
```

### Get Node Status

Get current status of the addressed node

```php
$client->nodeStatus();
```

### Get Settings

Get current chain parameters

```php
$client->settings();
```

### Get Block Info

Get information about the block without transactions

```php
$client->blockInfo('{HASH}');
```
Where `{HASH}` is hash of the block for which the information is needed.

### Get Block

Get information about the block

```php
$client->block('{HASH}');
```
Where `{HASH}` hash of the block for which the information is needed.

### Where Address

The definition of chain belonging to address.

```php
$client->where('{ADDRESS}');
```
Where `{ADDRESS}` is the address of the wallet in textual or binary representation in hex format.

### Get Address Info

Information about a wallet with a given address.

```php
$client->address('{ADDRESS}');
```
Where `{ADDRESS}` is the address of the wallet in textual or binary representation in hex format.
## Acknowledgements

 - [ThePower.io API Reference](https://doc.thepower.io/docs/Build/api/api-reference)
 - [ThePower.io About](https://thepower.io)

