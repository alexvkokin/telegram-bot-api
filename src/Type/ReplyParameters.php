<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#replyparameters
 */
final readonly class ReplyParameters
{
    public function __construct(
        public int $message_id,
        public int|string|null $chat_id = null,
        public ?bool $allow_sending_without_reply = null,
        public ?string $quote = null,
        public ?string $quote_parse_mode = null,
        public ?array $quote_entities = null,
        public ?int $quote_position = null,
    ) {}
}
