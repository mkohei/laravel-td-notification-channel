<!-- no toc -->
# Treasure Data notifications channel for Laravel

This package makes it easy to send [Treasure Data](https://www.treasuredata.com/) using the Laravel notification system and the [Treasure Data Postback API](https://docs.treasuredata.com/display/public/PD/Postback+API).

## Contents

- [Contents](#contents)
- [Installation](#installation)
- [Usage](#usage)
- [Testing](#testing)
- [License](#license)
## Installation

```
composer require mkohei/laravel-td-notification-channel
```

## Usage

Now you can use the channel in your via() method inside the notification:

```php
use Mkohei\LaravelTdNotificationChannel\TreasureDataChannel;
use Mkohei\LaravelTdNotificationChannel\TreasureDataMessage;
use Illuminate\Notifications\Notification;

class ProjectCreated extends Notification
{
    public function via($notifiable)
    {
        return [TreasureDataChannel::class];
    }

    public function toTreasureData($notifiable)
    {
        return TreasureDataMessage::create()
            ->data([
               'param1' => 'value',
               'param2' => 1234,
            ])
            ->apikey('YOUR_WRITE_ONLY_KEY')
            ->database('your_db')
            ->table('your_table');
    }
}
```

To store notifications in the appropriate regions, databases, and tables, define a `routeNotificationForTreasureData` method on your notifiable entity. This should return [the Postback API endpoint for your region](https://docs.treasuredata.com/display/public/PD/Sites+and+Endpoints).

```php
public function routeNotificationForTreasureData()
{
    return 'https://in.treasuredata.com';
}
```

## Testing

```
composer test
```

## License

[MIT License](./LICENSE).
