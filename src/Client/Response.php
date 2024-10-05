<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Client;

final readonly class Response
{
    public function __construct(
        public int $statusCode,
        public string $body,
    ) {}
}
