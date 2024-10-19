<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Client;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class TelegramClient implements Client
{
    public function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $httpRequestFactory,
        private StreamFactoryInterface $streamFactory,
    ) {}

    /**
     * @throws ClientExceptionInterface
     * @throws JsonException
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
     * @throws JsonException
     */
    private function post(Request $request): RequestInterface
    {
        $httpRequest = $this->createRequest($request);

        if (empty($request->params) && empty($request->files)) {
            return $httpRequest;
        }

        if (!empty($request->files)) {
            $streamBuilder = new MultipartStreamBuilder($this->streamFactory);

            foreach ($request->params as $key => $value) {
                $streamBuilder->addResource(
                    $key,
                    is_array($value) ? json_encode($value, JSON_THROW_ON_ERROR) : $value,
                );
            }

            foreach ($request->files as $key => $file) {
                $streamBuilder->addResource(
                    $key,
                    $file->resource,
                    $file->filename !== null ? ['filename' => $file->filename] : [],
                );
            }

            $body = $streamBuilder->build();
            $contentType = 'multipart/form-data; boundary=' . $streamBuilder->getBoundary() . '; charset=utf-8';
        } else {
            $content = json_encode($request->params, JSON_THROW_ON_ERROR);
            $body = $this->streamFactory->createStream($content);
            $contentType = 'application/json; charset=utf-8';
        }

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