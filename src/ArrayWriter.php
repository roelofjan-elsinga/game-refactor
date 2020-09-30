<?php

declare(strict_types=1);

namespace App;

class ArrayWriter implements OutputWriter
{
    public $messages = [];

    public function write(string $message): void
    {
        $this->messages[] = $message;
    }
}