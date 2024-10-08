<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Tests\Support;

use Alexvkokin\TelegramBotApi\Client\Client;
use Alexvkokin\TelegramBotApi\Client\Request;
use Alexvkokin\TelegramBotApi\Client\Response;

final readonly class FakeClient implements Client
{
    public function __construct(
        private string $body,
        private int $statusCode = 200
    ) {}

    public function send(Request $request): Response
    {
        return new Response($this->statusCode, $this->body);
    }
}