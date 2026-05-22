<?php

declare(strict_types=1);

namespace Madkom\DockerRegistryApi\Authorization;

use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\Request;
use Psr\Http\Client\ClientInterface;

/**
 * No-op authorization. Use for registries that don't require auth.
 */
class EmptyAuthorization implements AuthorizationService
{
    public function authorizationHeader(ClientInterface $client, Request $resourceRequest): ?string
    {
        return null;
    }
}
