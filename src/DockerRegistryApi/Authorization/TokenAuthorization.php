<?php

declare(strict_types=1);

namespace Madkom\DockerRegistryApi\Authorization;

use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\DockerRegistryException;
use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request;
use Psr\Http\Client\ClientInterface;

/**
 * Authorization via the Docker Registry token-service flow
 * (e.g. Portus, Docker Hub auth.docker.io).
 */
class TokenAuthorization implements AuthorizationService
{
    public function __construct(
        private readonly string $username,
        private readonly string $password,
        private readonly string $registryServiceName,
        private readonly PsrHttpRequestFactory $authorizationFactory,
    ) {
    }

    public function authorizationHeader(ClientInterface $client, Request $resourceRequest): ?string
    {
        $authorizationRequest = $this->authorizationFactory->toPsrRequest(
            new Request\Authorization(
                $this->authorizationFactory->host(),
                $this->registryServiceName,
                $this->username,
                $this->password,
                $resourceRequest->scope(),
            ),
        );

        $response = $client->sendRequest($authorizationRequest);

        if ($response->getStatusCode() !== 200) {
            throw new DockerRegistryException(
                "Can't authorize with given credentials: " . $response->getBody()->getContents(),
            );
        }

        /** @var array{token?: string}|null $responseData */
        $responseData = json_decode($response->getBody()->getContents(), true);

        if (!is_array($responseData) || !isset($responseData['token']) || !is_string($responseData['token'])) {
            throw new DockerRegistryException('Authorization response did not contain a token.');
        }

        return 'Bearer ' . $responseData['token'];
    }
}
