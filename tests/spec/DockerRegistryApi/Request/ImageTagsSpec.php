<?php

declare(strict_types=1);

namespace spec\Madkom\DockerRegistryApi\Request;

use Madkom\DockerRegistryApi\Request;
use PhpSpec\ObjectBehavior;

class ImageTagsSpec extends ObjectBehavior
{
    private string $imageName = 'ubuntu';

    public function let(): void
    {
        $this->beConstructedWith($this->imageName);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Request::class);
    }

    public function it_should_return_values_it_was_constructed_with(): void
    {
        $this->uri()->shouldReturn('/v2/' . $this->imageName . '/tags/list');
        $this->headers()->shouldReturn([]);
        $this->scope()->shouldReturn('repository:ubuntu:pull');
        $this->method()->shouldReturn('GET');
        $this->data()->shouldReturn([]);
    }
}
