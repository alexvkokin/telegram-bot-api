<?php

declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Type;

use Psr\Http\Message\StreamInterface;
use RuntimeException;

/**
 * @see https://core.telegram.org/bots/api#sending-files
 */
final readonly class InputFile implements Type
{
    /**
     * @param resource|StreamInterface $resource
     */
    private function __construct(
        public mixed $resource,
        public ?string $filename = null,
    ) {}

    public static function withLocalFile(string $path, ?string $filename = null): self
    {
        $resource = fopen($path, 'r');
        if ($resource === false) {
            throw new RuntimeException('Unable to open file "' . $path . '".');
        }
        return new self($resource, $filename);
    }
}
