<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#forcereply
 */
final readonly class ForceReply
{
    public function __construct(
        public ?string $input_field_placeholder = null,
        public ?bool $selective = null,
    ) {}
}
