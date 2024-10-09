<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#inlinekeyboardbutton
 */
final readonly class InlineKeyboardButton implements Type
{
    public function __construct(
        public string $text,
        public ?string $url = null,
        public ?string $callback_data = null,
        public ?WebAppInfo $web_app = null,
        public ?LoginUrl $login_url = null,
        public ?string $switch_inline_query = null,
        public ?string $switch_inline_queryCurrentChat = null,
        public ?SwitchInlineQueryChosenChat $switch_inline_query_chosen_chat = null,
        public ?bool $pay = null,
    ) {}
}
