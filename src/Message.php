<?php


namespace igormakarov\KyivstarSms;


class Message
{
    private string $from, $to, $text;

    public function __construct(string $from, string $to, string $text)
    {
        $this->from = $from;
        $this->to = $to;
        $this->text = $text;
    }

    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }
}