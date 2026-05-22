<?php

declare(strict_types=1);

namespace spec\Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;

class AuthorizationSpec extends ObjectBehavior
{
    private string $registryHost = 'https://registry.com';
    private string $registryService = 'registry.com';
    private string $username = 'Franek';
    private string $password = 'Majehan';
    private string $scope = 'registry:catalog:*';

    public function let(): void
    {
        $this->beConstructedWith(
            $this->registryHost,
            $this->registryService,
            $this->username,
            $this->password,
            $this->scope,
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Request::class);
    }

    public function it_should_return_values_it_constructed_with(): void
    {
        $this->uri()->shouldReturn('/v2/token?service=registry.com&scope=registry:catalog:*');
        $this->headers()->shouldReturn([
            'Authorization' => 'Basic RnJhbmVrOk1hamVoYW4=',
        ]);
        $this->scope()->shouldReturn($this->scope);
        $this->method()->shouldReturn('GET');
        $this->data()->shouldReturn([]);
    }
}
