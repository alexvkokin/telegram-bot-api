<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#switchinlinequerychosenchat
 */
final readonly class SwitchInlineQueryChosenChat implements Type
{
    public function __construct(
        public ?string $query = null,
        public ?bool $allow_user_chats = null,
        public ?bool $allow_bot_chats = null,
        public ?bool $allow_group_chats = null,
        public ?bool $allow_channel_chats = null,
    ) {}
}
