<?php

declare(strict_types=1);

namespace spec\Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;

class CatalogSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Request::class);
    }

    public function it_should_return_values_it_was_constructed_with(): void
    {
        $this->uri()->shouldReturn('/v2/_catalog');
        $this->headers()->shouldReturn([]);
        $this->scope()->shouldReturn('registry:catalog:*');
        $this->method()->shouldReturn('GET');
        $this->data()->shouldReturn([]);
    }
}
