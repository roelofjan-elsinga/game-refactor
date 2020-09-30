<?php

namespace App;

interface OutputWriter
{
    public function write(string $message): void;
}