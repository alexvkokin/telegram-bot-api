<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
final readonly class InlineKeyboardMarkup implements Type
{
    /**
     * @psalm-param array<array-key, array<array-key, InlineKeyboardButton>> $inline_keyboard
     */
    public function __construct(
        public array $inline_keyboard,
    ) {
    }
}
