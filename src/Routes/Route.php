<?php


namespace igormakarov\KyivstarSms\Routes;


class Route
{
    public string $url;
    public string $method;

    public function __construct(string $url, string $method = 'GET')
    {
        $this->url = $url;
        $this->method = $method;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function method(): string
    {
        return $this->method;
    }
}