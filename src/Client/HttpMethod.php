<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Client;

enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
}
