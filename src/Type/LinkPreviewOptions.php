<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#linkpreviewoptions
 */
final readonly class LinkPreviewOptions implements Type
{
    public function __construct(
        public ?bool $is_disabled = null,
        public ?string $url = null,
        public ?bool $prefer_small_media = null,
        public ?bool $prefer_large_media = null,
        public ?bool $show_above_text = null,
    ) {}
}
