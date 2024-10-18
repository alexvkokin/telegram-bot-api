<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Tests\Data;

use Alexvkokin\TelegramBotApi\Client\HttpMethod;
use Alexvkokin\TelegramBotApi\Method\Method;
use Alexvkokin\TelegramBotApi\Type\InlineKeyboardMarkup;
use Alexvkokin\TelegramBotApi\Type\Message;

final readonly class MessageWithKeyboard implements Method
{
    public function __construct(
        public InlineKeyboardMarkup $reply_markup,
    )
    {
    }

    public function method(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function responseClassName(): string
    {
        return Message::class;
    }
}