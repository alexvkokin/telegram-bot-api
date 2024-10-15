<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Client;

final readonly class Request
{
    public function __construct(
        public string $uri,
        public HttpMethod $method,
        public array $params = [],
        public array $files = [],
    ) {}
}