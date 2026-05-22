<?php

declare(strict_types=1);

namespace spec\Madkom\DockerRegistryApi\Authorization;

use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;
use Psr\Http\Client\ClientInterface;

class BasicAuthorizationSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('username', 'password');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(AuthorizationService::class);
    }

    public function it_should_return_authorization_string(ClientInterface $client, Request $request): void
    {
        $this->authorizationHeader($client, $request)
            ->shouldReturn('Basic ' . base64_encode('username:password'));
    }
}
