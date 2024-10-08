<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Method;

use Alexvkokin\TelegramBotApi\Client\HttpMethod;
use Alexvkokin\TelegramBotApi\Type\User;

/**
 * @see https://core.telegram.org/bots/api#getchat
 */
final readonly class GetMe implements Method
{
    public function method(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function responseClassName(): string
    {
        return User::class;
    }
}
