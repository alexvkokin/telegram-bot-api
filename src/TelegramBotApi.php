<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi;

use Alexvkokin\TelegramBotApi\Client\Client;
use Alexvkokin\TelegramBotApi\Client\Request;
use Alexvkokin\TelegramBotApi\Method\Method;
use Alexvkokin\TelegramBotApi\Parser\MethodParser;
use Alexvkokin\TelegramBotApi\Parser\ResponseParser;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use RuntimeException;
use Throwable;

final readonly class TelegramBotApi
{
    private string $baseUrl;

    public function __construct(
        string $token,
        private Client $client,
        string $baseUrl = 'https://api.telegram.org',
        private MethodParser $methodParser = new MethodParser(),
        private ResponseParser $responseParser = new ResponseParser(),
    ) {
        $this->baseUrl = $baseUrl . '/bot' . $token . '/';
    }

    /**
     * @throws RuntimeException
     */
    public function send(Method $method): object
    {
        try {
            $request = new Request(
                $this->getUrl($method),
                $method->method(),
                $this->methodParser->getParams($method),
            );
            $response = $this->client->send($request);

        } catch (ClientExceptionInterface $e) {
            throw new RuntimeException('Error sending request.', previous: $e);
        }

        try {
            $body = json_decode($response->body, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Error parsing response.', previous: $e);
        }

        $fieldOk = $body['ok'] ?? null;

        if ($fieldOk === null) {
            throw new RuntimeException('Incorrect "ok" field in response. Expected boolean, got ' . gettype($fieldOk));
        }

        if ($fieldOk === true) {
            try {
                return $this->responseParser->asObject($method->responseClassName(), $body['result'] ?? []);
            } catch (Throwable $e) {
                throw new RuntimeException('Error parsing response.', previous: $e);
            }
        }

        return $this->getFailureResult();
    }

    private function getFailureResult(): object
    {
        return new \stdClass();
    }

    private function getUrl(Method $method): string
    {
        return $this->baseUrl . $this->methodParser->getName($method);
    }
}