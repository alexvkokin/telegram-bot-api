<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi;

use Alexvkokin\TelegramBotApi\Client\Request;
use Alexvkokin\TelegramBotApi\Client\Response;
use Alexvkokin\TelegramBotApi\Client\TelegramClient;
use Alexvkokin\TelegramBotApi\Method\Method;
use Alexvkokin\TelegramBotApi\Parser\MethodParser;
use Psr\Http\Client\ClientExceptionInterface;

final readonly class TelegramBotApi
{
    private string $baseUrl;

    public function __construct(
        string $token,
        private TelegramClient $client,
        string $baseUrl = 'https://api.telegram.org',
        private MethodParser $methodParser = new MethodParser(),

    ) {
        $this->baseUrl = $baseUrl . '/bot' . $token . '/';
    }

    /**
     * @throws ClientExceptionInterface
     * @throws \JsonException
     */
    public function send(Method $method): Response
    {
        $request = new Request(
            $this->getUrl($method),
            $method->method(),
            $this->methodParser->getParams($method),
        );

        return $this->client->send($request);
    }

    private function getUrl(Method $method): string
    {
        return $this->baseUrl . $this->methodParser->getName($method);
    }
}