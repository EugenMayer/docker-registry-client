<?php

declare(strict_types=1);

namespace Madkom\DockerRegistryApi;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * High-level Docker Registry client.
 *
 * Wraps a PSR-18 HTTP client, converts {@see Request} objects into PSR-7
 * requests, and decorates them with an Authorization header obtained from
 * an {@see AuthorizationService}.
 */
class HttpDockerRegistryClient
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly PsrHttpRequestFactory $psrHttpRequestFactory,
        private readonly AuthorizationService $authorizationService,
    ) {
    }

    /**
     * Send the given request to the registry.
     *
     * @throws DockerRegistryException     When authorization fails.
     * @throws ClientExceptionInterface    When the underlying transport fails.
     */
    public function handle(Request $request): ResponseInterface
    {
        $authorizationHeader = $this->authorizationService->authorizationHeader($this->client, $request);

        $psrRequest = $this->psrHttpRequestFactory->toPsrRequest($request);

        if ($authorizationHeader !== null) {
            $psrRequest = $psrRequest->withHeader('Authorization', $authorizationHeader);
        }

        return $this->client->sendRequest($psrRequest);
    }
}
