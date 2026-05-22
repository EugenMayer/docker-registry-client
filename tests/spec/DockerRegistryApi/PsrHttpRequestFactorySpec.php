<?php

declare(strict_types=1);

namespace spec\Madkom\DockerRegistryApi;

use Madkom\DockerRegistryApi\PsrHttpRequestFactory;
use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;

class PsrHttpRequestFactorySpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('http://localhost:812');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PsrHttpRequestFactory::class);
    }

    public function it_should_create_psr_request(Request $request): void
    {
        $request->uri()->willReturn('/v2/Something');
        $request->headers()->willReturn(['Content-Type' => 'application/json']);
        $request->method()->willReturn('GET');
        $request->data()->willReturn([]);

        $psrRequest = $this->toPsrRequest($request);
        $psrRequest->shouldHaveType(RequestInterface::class);
        $psrRequest->getRequestTarget()->shouldReturn('/v2/Something');
        $psrRequest->getUri()->getHost()->shouldReturn('localhost');
        $psrRequest->getUri()->getPort()->shouldReturn(812);
        $psrRequest->getMethod()->shouldReturn('GET');
        $psrRequest->getHeaders()->shouldReturn([
            'Host' => ['localhost:812'],
            'Content-Type' => ['application/json'],
        ]);
    }

    public function it_should_return_host(): void
    {
        $this->host()->shouldReturn('http://localhost:812');
    }
}
