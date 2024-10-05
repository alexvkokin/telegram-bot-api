<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#loginurl
 */
final readonly class LoginUrl
{
    public function __construct(
        public string $url,
        public ?string $forward_text = null,
        public ?string $bot_username = null,
        public ?bool $request_write_access = null,
    ) {}
}
