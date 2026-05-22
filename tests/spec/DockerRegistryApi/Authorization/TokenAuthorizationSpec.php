<?php

declare(strict_types=1);

namespace spec\Madkom\DockerRegistryApi\Authorization;

use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\DockerRegistryException;
use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class TokenAuthorizationSpec extends ObjectBehavior
{
    private $authorizationRequestFactory;

    public function let(PsrHttpRequestFactory $authorizationRequestFactory): void
    {
        $this->authorizationRequestFactory = $authorizationRequestFactory;
        $this->beConstructedWith('login', 'password', 'registryServiceName', $authorizationRequestFactory);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(AuthorizationService::class);
    }

    public function it_should_return_authorization_string(
        ClientInterface $client,
        Request $request,
        ResponseInterface $responseInterface,
        StreamInterface $streamInterface,
        RequestInterface $authorizationPsrRequest,
    ): void {
        $this->authorizationRequestFactory->host()->willReturn('https://portus.com');
        $this->authorizationRequestFactory->toPsrRequest(Argument::type(Request\Authorization::class))
            ->willReturn($authorizationPsrRequest);

        $client->sendRequest($authorizationPsrRequest)->willReturn($responseInterface);

        $responseInterface->getStatusCode()->willReturn(200);
        $responseInterface->getBody()->willReturn($streamInterface);
        $streamInterface->getContents()->willReturn(json_encode(['token' => 'someGeneratedToken']));

        $this->authorizationHeader($client, $request)->shouldReturn('Bearer someGeneratedToken');
    }

    public function it_should_throw_exception_if_no_authorized(
        ClientInterface $client,
        Request $request,
        ResponseInterface $responseInterface,
        StreamInterface $streamInterface,
        RequestInterface $authorizationPsrRequest,
    ): void {
        $this->authorizationRequestFactory->host()->willReturn('https://portus.com');
        $this->authorizationRequestFactory->toPsrRequest(Argument::type(Request\Authorization::class))
            ->willReturn($authorizationPsrRequest);

        $client->sendRequest($authorizationPsrRequest)->willReturn($responseInterface);

        $responseInterface->getStatusCode()->willReturn(403);
        $responseInterface->getBody()->willReturn($streamInterface);
        $streamInterface->getContents()->willReturn('not authorized');

        $this->shouldThrow(DockerRegistryException::class)
            ->during('authorizationHeader', [$client, $request]);
    }
}
