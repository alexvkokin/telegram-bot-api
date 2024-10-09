<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#message
 */
final readonly class Message implements Type
{
    public function __construct(
        public int $message_id,
        public int $date,
        public Chat $chat,
        public ?int $message_thread_id = null,
        public ?User $from = null,
        public ?Chat $sender_chat = null,
        public ?string $text = null,
    ) {}
}