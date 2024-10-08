<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Client;

use Psr\Http\Client\ClientExceptionInterface;

interface Client
{
    /**
     * @throws ClientExceptionInterface
     */
    public function send(Request $request): Response;
}