<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Client;

use JsonException;
use Psr\Http\Client\ClientExceptionInterface;

interface Client
{
    /**
     * @throws ClientExceptionInterface
     * @throws JsonException
     */
    public function send(Request $request): Response;
}