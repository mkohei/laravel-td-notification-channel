<?php

use Illuminate\Support\Arr;
use Mkohei\LaravelTdNotificationChannel\TreasureDataMessage;

beforeEach(function () {
    $this->message = new TreasureDataMessage();
});

it('accepts data when constructing a message', function () {
    $message = new TreasureDataMessage(['foo' => 'bar']);
    $this->assertEquals(['foo' => 'bar'], Arr::get($message->toArray(), 'data'));
});

it('provides a create method', function () {
    $message = TreasureDataMessage::create(['foo' => 'bar']);
    $this->assertEquals(['foo' => 'bar'], Arr::get($message->toArray(), 'data'));
});

it('can set a treasure data apikey', function () {
    $this->message->apikey('apikey');
    $this->assertEquals('apikey', Arr::get($this->message->toArray(), 'apikey'));
});

it('can set a treasure data database', function () {
    $this->message->database('test_db');
    $this->assertEquals('test_db', Arr::get($this->message->toArray(), 'database'));
});
it('can set a treasure data table', function () {
    $this->message->table('test_table');
    $this->assertEquals('test_table', Arr::get($this->message->toArray(), 'table'));
});

it("can set a treasure data's data", function () {
    $this->message->data(['foo' => 'bar']);
    $this->assertEquals(['foo' => 'bar'], Arr::get($this->message->toArray(), 'data'));
});
