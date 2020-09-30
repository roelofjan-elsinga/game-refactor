<?php

namespace App;

class ArrayWriter implements OutputWriter
{
    public $messages = [];

    public function write(string $message): void
    {
        $this->messages[] = $message;
    }
}