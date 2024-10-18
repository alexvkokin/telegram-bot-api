<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Tests\Parser;

use Alexvkokin\TelegramBotApi\Method\Method;
use Alexvkokin\TelegramBotApi\Parser\MethodParser;
use Alexvkokin\TelegramBotApi\Tests\Data\FileClass;
use Alexvkokin\TelegramBotApi\Tests\Data\MessageWithKeyboard;
use Alexvkokin\TelegramBotApi\Tests\Data\SimpleClass;
use Alexvkokin\TelegramBotApi\Type\InlineKeyboardButton;
use Alexvkokin\TelegramBotApi\Type\InlineKeyboardMarkup;
use Alexvkokin\TelegramBotApi\Type\InputFile;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Alexvkokin\TelegramBotApi\Parser\MethodParser
 */
class MethodParserTest extends TestCase
{
    public static function paramsDataProvider(): array
    {
        $file = InputFile::withLocalFile(__FILE__, 'file_name.jpg');

        return [
            'class with simple fields' => [
                new SimpleClass(chat_id: 123, text: 'test', optional: 'optional'),
                ['chat_id' => '123', 'text' => 'test', 'optional' => 'optional'],
                [],
            ],
            'class with file' => [
                new FileClass(chat_id: 123, photo: $file),
                ['chat_id' => '123'],
                ['photo' => $file],
            ],
            'class with file as string' => [
                new FileClass(chat_id: 123, photo: 'file_id'),
                ['chat_id' => '123', 'photo' => 'file_id'],
                [],
            ],
            'class with optional properties' => [
                new SimpleClass(chat_id: 123, text: 'test'),
                ['chat_id' => '123', 'text' => 'test'],
                [],
            ],
            'class with type property' => [
                new MessageWithKeyboard(new InlineKeyboardMarkup([
                    [
                        new InlineKeyboardButton(text: 'test1', callback_data: 'callback1'),
                        new InlineKeyboardButton(text: 'test2', callback_data: 'callback2'),
                    ],
                    [
                        new InlineKeyboardButton(text: 'test3', callback_data: 'callback3'),
                    ],
                ])),
                ['reply_markup' =>
                    ['inline_keyboard' =>
                        [
                            [
                                ['text' => 'test1', 'callback_data' => 'callback1'],
                                ['text' => 'test2', 'callback_data' => 'callback2'],
                            ],
                            [
                                ['text' => 'test3', 'callback_data' => 'callback3'],
                            ],
                        ],
                    ]
                ],
                [],
            ],
        ];
    }

    /**
     * @dataProvider paramsDataProvider()
     */
    public function test_get_params(Method $instance, array $expected, array $expectedFiles): void
    {
        $parser = new MethodParser();

        $actual = $parser->getParams($instance);
        $actualFiles = $parser->getFiles($instance);

        $this->assertSame($expected, $actual);
        $this->assertSame($expectedFiles, $actualFiles);
    }
}

