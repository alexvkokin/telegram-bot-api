<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
final readonly class InlineKeyboardMarkup
{
    public function __construct(
        public array $inline_keyboard,
    ) {}
}
