<?php

namespace igormakarov\KyivstarSms;

use igormakarov\KyivstarSms\Exceptions\IllegalArgumentException;

class Message
{
    private string $from, $to, $text;

    /**
     * @throws IllegalArgumentException
     */
    public function __construct(string $from, string $to, string $text)
    {
        $this->from = $from;
        $this->to = $to;
        $this->text = $text;
        $this->validate();
    }

    /**
     * @throws IllegalArgumentException
     */
    private function validate()
    {
        $missingData = [];
        if (empty(trim($this->from))) {
            $missingData[] = 'From';
        }

        if (empty(trim($this->to))) {
            $missingData[] = 'To';
        }

        if (empty(trim($this->text))) {
            $missingData[] = 'Text';
        }

        if (!empty($missingData)) {
            $missingParams = "'" . implode(', ', $missingData) . "'";
            throw new IllegalArgumentException($missingParams . ' is missing', 99999);
        }
    }

    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }
}
