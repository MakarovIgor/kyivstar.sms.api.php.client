[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
# kyivstar.sms.api.php.client - клієнт для роботи з Київстар Відкритий Телеком API

#### Офіційна документація:
https://api-gateway.kyivstar.ua/#overview

#### Приклад коду
```php
<?php

use igormakarov\KyivstarSms\Exceptions\UnauthorizedException;
use igormakarov\KyivstarSms\KyivstarAuth;
use igormakarov\KyivstarSms\KyivstarSmsClient;
use igormakarov\KyivstarSms\Message;

require_once 'vendor/autoload.php';

$url = 'https://api-gateway.kyivstar.ua/mock/rest/v1beta';

try {
    $kyivstarAuth = new KyivstarAuth();
    $accessToken = $kyivstarAuth->getToken('clientId', 'secretKey');

    $client = new KyivstarSmsClient($url, $accessToken['access_token']);
    $msgId = $client->sendSms(new Message("messagedesk", "+380679000000", "це тест"));
    $status = $client->deliveryStatusSms($msgId);
    var_dump($status);
} catch (Exception $ex) {
    var_dump("code ", $ex->getCode());
    var_dump("message ", $ex->getMessage());
}
```
