<?php

declare(strict_types=1);

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