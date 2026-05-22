<?php

declare(strict_types=1);

namespace Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;

/**
 * GET /v2/{name}/tags/list — list tags for a given image.
 */
class ImageTags implements Request
{
    public function __construct(private readonly string $imageName)
    {
    }

    public function method(): string
    {
        return 'GET';
    }

    public function uri(): string
    {
        return '/v2/' . $this->imageName . '/tags/list';
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
        return 'repository:' . $this->imageName . ':pull';
    }
}
