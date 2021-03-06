<?php

declare(strict_types=1);

namespace App;


class RockQuestion extends BaseQuestion implements Question
{
    public static function forIndex(int $index): Question
    {
        return new static("Rock Question {$index}");
    }
}