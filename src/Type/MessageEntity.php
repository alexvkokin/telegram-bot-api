<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#messageentity
 */
final readonly class MessageEntity
{
    public function __construct(
        public string $type,
        public int $offset,
        public int $length,
        public ?string $url = null,
        public ?User $user = null,
        public ?string $language = null,
        public ?string $custom_emoji_id = null,
    ) {}
}
