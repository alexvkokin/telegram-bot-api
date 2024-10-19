<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Client;

use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Log\LoggerInterface;

final readonly class TelegramClientLogger implements Client
{
    public function __construct(
        private Client $client,
        private LoggerInterface $logger,
    ) {}

    /**
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function send(Request $request): Response
    {
        $this->logger->info('Request', [$request]);

        $response = $this->client->send($request);

        $this->logger->info('Response', [$response]);

        return $response;
    }
}