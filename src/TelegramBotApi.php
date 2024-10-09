<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi;

use Alexvkokin\TelegramBotApi\Client\Client;
use Alexvkokin\TelegramBotApi\Client\Request;
use Alexvkokin\TelegramBotApi\Client\Response;
use Alexvkokin\TelegramBotApi\Method\Method;
use Alexvkokin\TelegramBotApi\Parser\MethodParser;
use Alexvkokin\TelegramBotApi\Parser\ResponseParser;
use Alexvkokin\TelegramBotApi\Type\FailResponse;
use Alexvkokin\TelegramBotApi\Type\Type;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use RuntimeException;
use Throwable;

final readonly class TelegramBotApi
{
    public function __construct(
        private string $token,
        private Client $client,
        private string $baseUrl = 'https://api.telegram.org',
        private MethodParser $methodParser = new MethodParser(),
        private ResponseParser $responseParser = new ResponseParser(),
    ) {}

    /**
     * @throws RuntimeException
     */
    public function send(Method $method): Type
    {
        $response = $this->request($method);

        [$fieldOk, $fieldResult] = $this->decodeBody($response->body);

        if ($fieldOk === true) {
            return $this->getResult($method, $fieldResult);
        }

        return $this->getFailureResult();
    }


    private function request(Method $method): Response
    {
        try {
            $request = new Request(
                $this->getUrl($method),
                $method->method(),
                $this->methodParser->getParams($method),
            );

            return $this->client->send($request);

        } catch (ClientExceptionInterface $e) {
            throw new RuntimeException('Error sending request.', previous: $e);
        }
    }

    private function getUrl(Method $method): string
    {
        return $this->baseUrl . '/bot' . $this->token . '/' . $this->methodParser->getName($method);
    }

    private function decodeBody(string $body): array
    {
        try {
            $decodedBody = json_decode($body, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Error parsing response.', previous: $e);
        }

        $fieldOk = $decodedBody['ok'] ?? null;
        $fieldResult = $decodedBody['result'] ?? null;

        if ($fieldOk === null) {
            throw new RuntimeException('Incorrect "ok" field in response. Expected boolean, got ' . gettype($fieldOk));
        }

        return [$fieldOk, $fieldResult];
    }

    private function getResult(Method $method, array $result): Type
    {
        try {
            return $this->responseParser->asObject($method->responseClassName(), $result);
        } catch (Throwable $e) {
            throw new RuntimeException('Error parsing response.', previous: $e);
        }
    }

    private function getFailureResult(): Type
    {
        return new FailResponse();
    }
}