<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Method;

use Alexvkokin\TelegramBotApi\Client\HttpMethod;
use Alexvkokin\TelegramBotApi\Type\InlineKeyboardMarkup;
use Alexvkokin\TelegramBotApi\Type\Message;

/**
 * @see https://core.telegram.org/bots/api#sendmessage
 */
final readonly class SendMessage implements Method
{
    public function __construct(
        public int|string $chat_id,
        public string $text,
        public InlineKeyboardMarkup|null $reply_markup = null,
    ) {}

    public function method(): HttpMethod
    {
        return HttpMethod::POST;
    }

    /**
     * @return class-string<Message>
     */
    public function responseClassName(): string
    {
        return Message::class;
    }
}
