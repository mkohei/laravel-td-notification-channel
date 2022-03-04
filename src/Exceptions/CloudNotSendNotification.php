<?php

namespace Mkohei\LaravelTdNotificationChannel\Exceptions;

use GuzzleHttp\Psr7\Response;

class CloudNotSendNotification extends \Exception
{
    private Response $response;

    public function __construct(Response $response, string $message, int $code = null)
    {
        $this->response = $response;
        $this->message = $message;
        $this->code = $code ?? $response->getStatusCode() ?? 0;

        parent::__construct($message, $this->code);
    }

    public static function serviceRespondedWithAnError(Response $response): self
    {
        return new self(
            $response,
            sprintf('Treasure Data responded with an error: `%s`', $response->getBody()->getContents())
        );
    }

    public function response(): Response
    {
        return $this->response;
    }
}
