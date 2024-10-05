<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#webappinfo
 */
final readonly class WebAppInfo
{
    public function __construct(
        public string $url,
    ) {}
}
