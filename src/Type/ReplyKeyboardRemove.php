<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#replykeyboardremove
 */
final readonly class ReplyKeyboardRemove implements Type
{
    public function __construct(
        public ?bool $selective = null,
    ) {}
}
