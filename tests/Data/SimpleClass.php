<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Tests\Data;

use Alexvkokin\TelegramBotApi\Client\HttpMethod;
use Alexvkokin\TelegramBotApi\Method\Method;
use Alexvkokin\TelegramBotApi\Type\Message;

final readonly class SimpleClass implements Method
{
    public function __construct(
        public string|int $chat_id,
        public string $text,
        public ?string $optional = null,
    ) {}

    public function method(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function responseClassName(): string
    {
        return Message::class;
    }
}