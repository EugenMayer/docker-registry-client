<?php

declare(strict_types=1);

namespace spec\Madkom\DockerRegistryApi;

use PhpSpec\ObjectBehavior;

class DockerRegistryExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(\Exception::class);
    }
}
