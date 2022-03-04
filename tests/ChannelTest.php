<?php

// TODO:

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Mkohei\LaravelTdNotificationChannel\Exceptions\CloudNotSendNotification;
use Mkohei\LaravelTdNotificationChannel\TreasureDataChannel;
use Mkohei\LaravelTdNotificationChannel\TreasureDataMessage;
use \Mockery as m;

beforeEach(function () {
    $this->client = m::mock(Client::class);
    $this->channel = new TreasureDataChannel($this->client);
});

afterEach(function () {
    m::close();
});

it('can send a notification', function (int $code) {
    $response = new Response($code);
    $this->client->shouldReceive('post')->once()->with(
        'https://in.treasuredata.com/postback/v3/event/test_db/test_table',
        [
            'headers' => [
                'X-TD-Write-Key' => 'apikey',
            ],
            'json' => [
                'param1' => 'value',
                'param2' => 1234,
            ]
        ]
    )->andReturn($response);

    $this->channel->send(new TestNotifiable, new TestNotification);

})->with([200, 201]);

it('throws an exception when it cloud not sent the notification', function () {
    $response = new Response(500);
    $this->client->shouldReceive('post')->once()->andReturn($response);

    $this->expectException(CloudNotSendNotification::class);
    $this->expectExceptionMessage('Treasure Data responded with an error: ``');
    $this->expectExceptionCode(500);

    $this->channel->send(new TestNotifiable, new TestNotification);
});

class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForTreasureData(): string
    {
        return 'https://in.treasuredata.com';
    }
}

class TestNotification extends Notification
{
    public function toTreasureData($notifiable): TreasureDataMessage
    {
        return (new TreasureDataMessage())
            ->apikey('apikey')
            ->database('test_db')
            ->table('test_table')
            ->data([
                'param1' => 'value',
                'param2' => 1234,
            ]);
    }
}
