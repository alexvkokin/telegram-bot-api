# Telegram Bot API for PHP

## Requirements

- PHP 8.2 or higher.

## Installation

The package could be installed with [Composer](https://getcomposer.org/download/):

```shell
composer require alexvkokin/telegram-bot-api
```

## Example

```php
use Alexvkokin\TelegramBotApi\Client\TelegramClient;
use Alexvkokin\TelegramBotApi\Method\SendMessage;
use Alexvkokin\TelegramBotApi\Method\SendPhoto;
use Alexvkokin\TelegramBotApi\Method\GetMe;
use Alexvkokin\TelegramBotApi\TelegramBotApi;
use Alexvkokin\TelegramBotApi\Type\InputFile;
use GuzzleHttp\Client;
use HttpSoft\Message\RequestFactory;
use HttpSoft\Message\StreamFactory;

require_once __DIR__ . '/../../vendor/autoload.php';

$token = 'YOUR_BOT_TOKEN';
$chatId = 123456789;

// Telegram API BOT client
$api = new TelegramBotApi(
    $token,
    new TelegramClient(
        new Client(),
        new RequestFactory(),
        new StreamFactory(),
    )
);

// get bot info
$method = new GetMe();
$response = $api->send($method);

// send message
$method = new SendMessage(
    chat_id: $chatId,
    text: 'Hello, world!',
);
$response = $api->send($method);

// send local file
$method = new SendPhoto(
    chat_id: $chatId,
    photo: InputFile::withLocalFile(__DIR__.'/../imgs/screen.png', 'screenshot 1'),
);
$response = $api->send($method);
```