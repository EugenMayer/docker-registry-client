<?php

declare(strict_types=1);

namespace Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;

/**
 * Token-service authorization request.
 *
 * Built by {@see \Madkom\DockerRegistryApi\Authorization\TokenAuthorization}
 * to exchange basic credentials for a bearer token scoped to a resource.
 */
class Authorization implements Request
{
    public function __construct(
        private readonly string $registryHost,
        private readonly string $registryService,
        private readonly string $username,
        private readonly string $password,
        private readonly string $scope,
    ) {
    }

    public function method(): string
    {
        return 'GET';
    }

    public function uri(): string
    {
        return '/v2/token?service=' . $this->registryService . '&scope=' . $this->scope();
    }

    public function headers(): array
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->password),
        ];
    }

    public function data(): array
    {
        return [];
    }

    public function scope(): string
    {
        return $this->scope;
    }
}
