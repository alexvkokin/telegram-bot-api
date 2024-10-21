<?php
declare(strict_types = 1);

namespace Alexvkokin\TelegramBotApi\Type;

final readonly class BadResponse implements Type
{
    public function __construct(
        public int $error_code,
        public string $description,
    ) {}
}