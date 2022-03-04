<?php

namespace Mkohei\LaravelTdNotificationChannel;

class TreasureDataMessage
{
    protected ?string $apikey = null;
    protected ?string $database = null;
    protected ?string $table = null;
    protected array $data = [];

    public static function create(array $data = []): static
    {
        return new static($data);
    }

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function apikey(string $apikey): static
    {
        $this->apikey = $apikey;

        return $this;
    }

    public function database(string $database): static
    {
        $this->database = $database;

        return $this;
    }

    public function table(string $table): static
    {
        $this->table = $table;

        return $this;
    }

    public function data(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'apikey'   => $this->apikey,
            'database' => $this->database,
            'table'    => $this->table,
            'data'     => $this->data,
        ];
    }
}
