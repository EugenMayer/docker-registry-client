<?php

declare(strict_types=1);

namespace spec\Madkom\DockerRegistryApi;

use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\HttpDockerRegistryClient;
use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class HttpDockerRegistryClientSpec extends ObjectBehavior
{
    private $client;
    private $psrHttpRequestFactory;
    private $authorizationService;

    public function let(
        ClientInterface $client,
        PsrHttpRequestFactory $psrHttpRequestFactory,
        AuthorizationService $authorizationService,
    ): void {
        $this->client = $client;
        $this->psrHttpRequestFactory = $psrHttpRequestFactory;
        $this->authorizationService = $authorizationService;

        $this->beConstructedWith($client, $psrHttpRequestFactory, $authorizationService);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(HttpDockerRegistryClient::class);
    }

    public function it_should_handle_request(
        Request $resourceRequest,
        RequestInterface $psrResourceRequest,
    ): void {
        $this->authorizationService->authorizationHeader($this->client, $resourceRequest)
            ->willReturn('Basic someHash');

        $this->psrHttpRequestFactory->toPsrRequest($resourceRequest)->willReturn($psrResourceRequest);
        $psrResourceRequest->withHeader('Authorization', 'Basic someHash')
            ->shouldBeCalledTimes(1)
            ->willReturn($psrResourceRequest);

        $this->client->sendRequest($psrResourceRequest)->shouldBeCalledTimes(1);
        $this->handle($resourceRequest);
    }

    public function it_should_add_no_authorization_if_authorization_service_returns_null(
        Request $resourceRequest,
        RequestInterface $psrResourceRequest,
    ): void {
        $this->authorizationService->authorizationHeader($this->client, $resourceRequest)
            ->willReturn(null);

        $this->psrHttpRequestFactory->toPsrRequest($resourceRequest)->willReturn($psrResourceRequest);

        $this->client->sendRequest($psrResourceRequest)->shouldBeCalledTimes(1);
        $this->handle($resourceRequest);
    }
}
