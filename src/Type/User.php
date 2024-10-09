<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#user
 */
final readonly class User implements Type
{
    public function __construct(
        public int $id,
        public bool $is_bot,
        public string $first_name,
        public ?string $last_name = null,
        public ?string $username = null,
        public ?string $language_code = null,
        public ?true $is_premium = null,
        public ?true $added_to_attachment_menu = null,
        public ?bool $can_join_groups = null,
        public ?bool $can_read_all_group_messages = null,
        public ?bool $supports_inline_queries = null,
        public ?bool $can_connect_to_business = null,
        public ?bool $has_main_web_app = null,
    ) {}
}
