<?php

declare(strict_types=1);

namespace Madkom\DockerRegistryApi\Authorization;

use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\Request;
use Psr\Http\Client\ClientInterface;

/**
 * Authorization via HTTP Basic credentials.
 */
class BasicAuthorization implements AuthorizationService
{
    public function __construct(
        private readonly string $username,
        private readonly string $password,
    ) {
    }

    public function authorizationHeader(ClientInterface $client, Request $resourceRequest): ?string
    {
        return 'Basic ' . base64_encode($this->username . ':' . $this->password);
    }
}
