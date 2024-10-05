<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Method;

use Alexvkokin\TelegramBotApi\Client\HttpMethod;

interface Method
{
    public function method(): HttpMethod;
}