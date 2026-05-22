# Docker-Registry-API
![PHP 8.2+](https://img.shields.io/badge/PHP-8.2%20%7C%208.3%20%7C%208.4-8C9CB6.svg?style=flat)
[![Latest Stable Version](https://poser.pugx.org/madkom/docker-registry-api/v/stable)](https://packagist.org/packages/madkom/docker-registry-api)
[![License](https://poser.pugx.org/madkom/docker-registry-api/license)](https://packagist.org/packages/madkom/docker-registry-api)
[![Total Downloads](https://poser.pugx.org/madkom/docker-registry-api/downloads)](https://packagist.org/packages/madkom/docker-registry-api)

PHP client for the [Docker Registry HTTP API V2](https://docs.docker.com/registry/spec/api/).

All available actions live in `Madkom\DockerRegistryApi\Request`. Feel free to add new ones.

## Requirements

- PHP 8.2, 8.3, or 8.4
- A [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP client (Guzzle 7 is recommended and used in the examples)

## Installation

```bash
composer require madkom/docker-registry-api guzzlehttp/guzzle:^7.9
```

## Usage

The client accepts any PSR-18 `Psr\Http\Client\ClientInterface` implementation —
Guzzle 7 implements it natively, so no adapter package is required.

```php
use GuzzleHttp\Client;
use Madkom\DockerRegistryApi\Authorization\BasicAuthorization;
use Madkom\DockerRegistryApi\HttpDockerRegistryClient;
use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request\ImageTags;

$registryFactory = new PsrHttpRequestFactory('https://registry.example.com');
$authorizationService = new BasicAuthorization('user', 'pass');

$client = new HttpDockerRegistryClient(
    new Client(),
    $registryFactory,
    $authorizationService,
);

$response = $client->handle(new ImageTags('ubuntu'));
echo $response->getBody()->getContents();
```

See the `usage/` directory for examples covering empty, basic, and token-based authorization.

## Upgrading from 0.x

Version 1.0 drops the [HTTPlug](https://httplug.io/) v1 abstraction in favour of
PSR-18. If you were passing an `Http\Adapter\Guzzle6\Client` to
`HttpDockerRegistryClient`, replace it with `GuzzleHttp\Client` directly — Guzzle
7 implements `Psr\Http\Client\ClientInterface` out of the box.

## License

The MIT License (MIT) — see [LICENSE](LICENSE).
