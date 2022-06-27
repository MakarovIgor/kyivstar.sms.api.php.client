<?php

namespace igormakarov\KyivstarSms\Routes;

class Sms
{
    private string $route = '/sms';
    private string $fullRoute;

    public function __construct(string $apiServerUrl)
    {
        $this->fullRoute = $apiServerUrl . $this->route;
    }

    public function deliveryStatus(string $messageId): Route
    {
        return new Route($this->fullRoute . '/' . $messageId);
    }

    public function send(): Route
    {
        return new Route($this->fullRoute, 'POST');
    }


}