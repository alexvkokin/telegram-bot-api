<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#replykeyboardmarkup
 */
final readonly class ReplyKeyboardMarkup implements Type
{
    public function __construct(
        public array $keyboard,
        public ?bool $is_persistent = null,
        public ?bool $resize_keyboard = null,
        public ?bool $one_time_keyboard = null,
        public ?string $input_field_placeholder = null,
        public ?bool $selective = null,
    ) {}
}
