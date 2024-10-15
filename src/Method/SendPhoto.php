<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Method;

use Alexvkokin\TelegramBotApi\Client\HttpMethod;
use Alexvkokin\TelegramBotApi\Type\InputFile;
use Alexvkokin\TelegramBotApi\Type\Message;

/**
 * @see https://core.telegram.org/bots/api#sendphoto
 */
final readonly class SendPhoto implements Method
{
    public function __construct(
        public int|string $chat_id,
        public string|InputFile $photo,
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
