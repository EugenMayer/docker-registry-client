<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use Madkom\DockerRegistryApi\Authorization\BasicAuthorization;
use Madkom\DockerRegistryApi\Authorization\EmptyAuthorization;
use Madkom\DockerRegistryApi\Authorization\TokenAuthorization;
use Madkom\DockerRegistryApi\HttpDockerRegistryClient;
use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request\ImageTags;

// Guzzle 7 implements PSR-18 (Psr\Http\Client\ClientInterface) natively,
// so no adapter package is required.

// ---- No Authorization ----

$registryFactory = new PsrHttpRequestFactory('https://registry.com');
$authorizationService = new EmptyAuthorization();
$client = new HttpDockerRegistryClient(new Client(), $registryFactory, $authorizationService);

$request = new ImageTags('ubuntu');
$response = $client->handle($request);

dump($response->getBody()->getContents());


// ---- Basic Authorization ----

$registryFactory = new PsrHttpRequestFactory('https://registry.com');
$authorizationService = new BasicAuthorization('username', 'password');
$client = new HttpDockerRegistryClient(new Client(), $registryFactory, $authorizationService);

$request = new ImageTags('ubuntu');
$response = $client->handle($request);

dump($response->getBody()->getContents());


// ---- Token-based Authorization ----

$registryFactory = new PsrHttpRequestFactory('https://registry.com');
$authorizationFactory = new PsrHttpRequestFactory('https://portus.com');

$authorizationService = new TokenAuthorization('user', 'password', 'registry.com', $authorizationFactory);
$client = new HttpDockerRegistryClient(new Client(), $registryFactory, $authorizationService);

$request = new ImageTags('ubuntu');
$response = $client->handle($request);

dump($response->getBody()->getContents());
