<?php

declare(strict_types=1);

namespace Madkom\DockerRegistryApi;

use GuzzleHttp\Psr7\HttpFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Builds PSR-7 requests for a fixed host from {@see Request} objects.
 */
class PsrHttpRequestFactory
{
    private readonly RequestFactoryInterface $requestFactory;
    private readonly StreamFactoryInterface $streamFactory;

    /**
     * @param string                        $host           Base URI (scheme + host + optional port), e.g. "https://registry.com".
     * @param RequestFactoryInterface|null  $requestFactory PSR-17 request factory. Defaults to Guzzle's HttpFactory.
     * @param StreamFactoryInterface|null   $streamFactory  PSR-17 stream factory. Defaults to Guzzle's HttpFactory.
     */
    public function __construct(
        private readonly string $host,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
    ) {
        $guzzleFactory = new HttpFactory();
        $this->requestFactory = $requestFactory ?? $guzzleFactory;
        $this->streamFactory = $streamFactory ?? $guzzleFactory;
    }

    public function toPsrRequest(Request $request): RequestInterface
    {
        $psrRequest = $this->requestFactory->createRequest(
            $request->method(),
            $this->host . $request->uri(),
        );

        foreach ($request->headers() as $name => $value) {
            $psrRequest = $psrRequest->withHeader($name, $value);
        }

        $body = $this->streamFactory->createStream((string) json_encode($request->data()));

        return $psrRequest->withBody($body);
    }

    public function host(): string
    {
        return $this->host;
    }
}
