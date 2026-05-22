<?php

declare(strict_types=1);

namespace Madkom\DockerRegistryApi;

/**
 * Describes a single Docker Registry API request.
 *
 * Implementations carry all data needed to build a PSR-7 request
 * (method, uri, headers, body data) plus the authorization scope
 * required to access the resource.
 */
interface Request
{
    /**
     * Returns HTTP method: GET, POST, PUT, DELETE, ...
     */
    public function method(): string;

    /**
     * Endpoint URI (path + optional query), e.g. "/v2/".
     */
    public function uri(): string;

    /**
     * Request headers as an associative array.
     *
     * @return array<string, string>
     */
    public function headers(): array;

    /**
     * Request body data (will be JSON-encoded).
     *
     * @return array<string, mixed>
     */
    public function data(): array;

    /**
     * Authorization scope for this request, e.g. "registry:catalog:*".
     */
    public function scope(): string;
}
