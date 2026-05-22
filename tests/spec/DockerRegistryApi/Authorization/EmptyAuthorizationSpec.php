<?php

declare(strict_types=1);

namespace spec\Madkom\DockerRegistryApi\Authorization;

use Madkom\DockerRegistryApi\AuthorizationService;
use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;
use Psr\Http\Client\ClientInterface;

class EmptyAuthorizationSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(AuthorizationService::class);
    }

    public function it_should_return_empty_authorization_header(
        ClientInterface $client,
        Request $resourceRequest,
    ): void {
        $this->authorizationHeader($client, $resourceRequest)->shouldReturn(null);
    }
}
