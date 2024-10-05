<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Client;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class TelegramClient
{
    public function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $httpRequestFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    /**
     * @throws ClientExceptionInterface
     * @throws \JsonException
     */
    public function send(Request $request): Response
    {
        $httpResponse = $this->client->sendRequest(
            match ($request->method) {
                HttpMethod::GET => $this->get($request),
                HttpMethod::POST => $this->post($request),
            },
        );

        return new Response(
            $httpResponse->getStatusCode(),
            $httpResponse->getBody()->getContents(),
        );
    }

    private function get(Request $request): RequestInterface
    {
        return $this->createRequest($request);
    }

    /**
     * @throws \JsonException
     */
    private function post(Request $request): RequestInterface
    {
        $httpRequest = $this->createRequest($request);

        if (empty($request->params)) {
            return $httpRequest;
        }

        $content = json_encode($request->params, JSON_THROW_ON_ERROR);
        $body = $this->streamFactory->createStream($content);
        $contentType = 'application/json; charset=utf-8';

        return $httpRequest
            ->withHeader('Content-Length', (string) $body->getSize())
            ->withHeader('Content-Type', $contentType)
            ->withBody($body);
    }

    private function createRequest(Request $request): RequestInterface
    {
        return $this->httpRequestFactory->createRequest(
            $request->method->value,
            $request->uri,
        );
    }
}