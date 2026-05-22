<?php

declare(strict_types=1);

namespace Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;

/**
 * GET /v2/_catalog — list all repositories in the registry.
 */
class Catalog implements Request
{
    public function method(): string
    {
        return 'GET';
    }

    public function uri(): string
    {
        return '/v2/_catalog';
    }

    public function headers(): array
    {
        return [];
    }

    public function data(): array
    {
        return [];
    }

    public function scope(): string
    {
        return 'registry:catalog:*';
    }
}
