<?php

declare(strict_types=1);

namespace Madkom\DockerRegistryApi;

use Psr\Http\Client\ClientInterface;

/**
 * Produces the Authorization header value for a resource request.
 *
 * Implementations may return null to signal that no Authorization
 * header should be added.
 */
interface AuthorizationService
{
    /**
     * Build the value for the "Authorization" header.
     *
     * @param ClientInterface $client          PSR-18 client used to perform
     *                                         any auxiliary calls (e.g. token
     *                                         exchange).
     * @param Request         $resourceRequest The resource request that is
     *                                         about to be sent and needs
     *                                         authorizing.
     *
     * @return string|null Authorization header value, or null for no header.
     *
     * @throws DockerRegistryException
     */
    public function authorizationHeader(ClientInterface $client, Request $resourceRequest): ?string;
}
