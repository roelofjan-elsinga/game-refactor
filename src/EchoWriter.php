<?php

namespace App;

/**
 * @codeCoverageIgnore
 */
class EchoWriter implements OutputWriter
{
    public function write(string $message): void
    {
        echo $message."\n";
    }
}