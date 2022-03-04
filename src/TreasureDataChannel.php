<?php

namespace Mkohei\LaravelTdNotificationChannel;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Mkohei\LaravelTdNotificationChannel\Exceptions\CloudNotSendNotification;

class TreasureDataChannel
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send a given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \Mkohei\LaravelTdNotificationChannel\Exceptions\CloudNotSendNotification
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function send(mixed $notifiable, Notification $notification): ?Response
    {
        if (!$url = $notifiable->routeNotificationFor('treasure_data')) {
            return null;
        }

        $tdData = $notification->toTreasureData($notifiable)->toArray();

        $url .= '/postback/v3/event/'.Arr::get($tdData, 'database').'/'.Arr::get($tdData, 'table');

        $response = $this->client->post($url, [
            'headers' => ['X-TD-Write-Key' => Arr::get($tdData, 'apikey')],
            'json'    => Arr::get($tdData, 'data'),
        ]);

        if ($response->getStatusCode() >= 300 || $response->getStatusCode() < 200) {
            throw CloudNotSendNotification::serviceRespondedWithAnError($response);
        }

        return $response;
    }
}
