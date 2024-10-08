<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Method;

use Alexvkokin\TelegramBotApi\Client\HttpMethod;

interface Method
{
    public function method(): HttpMethod;

    /**
     * @return class-string Name of the class that will be used to parse the response
     */
    public function responseClassName(): string;
}