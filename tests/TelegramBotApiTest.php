<?php
declare(strict_types=1);

namespace Alexvkokin\TelegramBotApi\Tests;

use Alexvkokin\TelegramBotApi\Client\Client;
use Alexvkokin\TelegramBotApi\Client\Response;
use Alexvkokin\TelegramBotApi\Method\GetMe;
use Alexvkokin\TelegramBotApi\Method\SendMessage;
use Alexvkokin\TelegramBotApi\TelegramBotApi;
use Alexvkokin\TelegramBotApi\Type\BadResponse;
use Alexvkokin\TelegramBotApi\Type\Chat;
use Alexvkokin\TelegramBotApi\Type\Message;
use Alexvkokin\TelegramBotApi\Type\User;
use PHPUnit\Framework\TestCase;
use RuntimeException;


/**
 * @covers \Alexvkokin\TelegramBotApi\TelegramBotApi
 */
class TelegramBotApiTest extends TestCase
{
    public function test_get_me_method(): void
    {
        $method = new GetMe();
        $sut = $this->getSut(200, '{"ok":true,"result":{"id":364329248,"is_bot":true,"first_name":"Some Bot","username":"SomeBot","can_join_groups":true,"can_read_all_group_messages":false,"supports_inline_queries":false,"can_connect_to_business":false,"has_main_web_app":false}}');

        $result = $sut->send($method);

        $this->assertEquals($result, new User(364329248, true, 'Some Bot', null, "SomeBot", null, null, null, true, false, false, false, false));
    }

    public function test_get_me_method_bad_result(): void
    {
        $method = new GetMe();
        $sut = $this->getSut(200, '{"ok":true,"result":{"id_bad":364329248}');

        $this->expectException(RuntimeException::class);
        $result = $sut->send($method);
    }

    public function test_send_message_method(): void
    {
        $method = new SendMessage(32323232, 'Hello, World!');
        $sut = $this->getSut(200, '{"ok":true,"result":{"message_id":55016,"from":{"id":364329248,"is_bot":true,"first_name":"Some Bot","username":"SomeBot"},"chat":{"id":32323232,"first_name":"MrX","username":"MrX0001","type":"private"},"date":1728315927,"text":"Hello, world!"}}');

        $result = $sut->send($method);

        $this->assertEquals($result, new Message(
            message_id: 55016,
            date: 1728315927,
            chat: new Chat(32323232, 'private', null,'MrX0001', 'MrX', null),
            from: new User(364329248, true, 'Some Bot', null, 'SomeBot'),
            text: 'Hello, world!',
        ));
    }


    public function test_send_message_method_bad_result(): void
    {
        $method = new SendMessage(32323232, 'Hello, World!');
        $sut = $this->getSut(200, '{"ok":true,"result":{"message_id":55016,"from":{"id":364329248,"is_bot":true,"first_name":"Some Bot","username":"SomeBot"},"chat":32323232,"date":1728315927,"text":"Hello, world!"}}');

        $this->expectException(RuntimeException::class);
        $result = $sut->send($method);
    }

    public function test_send_message_method_bad_response(): void
    {
        $method = new SendMessage(0, 'Hello, World!');
        $sut = $this->getSut(400, '{"ok":false,"error_code":400,"description":"Bad Request: chat not found"}');

        $result = $sut->send($method);

        $this->assertEquals(
            $result,
            new BadResponse(
                error_code: 400,
                description: "Bad Request: chat not found",
            )
        );
    }


    private function getSut(int $code, string $jsonResponse): TelegramBotApi
    {
        $token = 'xxx';

        $client = $this->createStub(Client::class);
        $client
            ->method('send')
            ->willReturn(new Response($code, $jsonResponse));

        $sut = new TelegramBotApi($token, $client);

        return $sut;
    }

}