<?php

declare(strict_types=1);

namespace App;


class SportsQuestion extends BaseQuestion implements Question
{
    public static function forIndex(int $index): Question
    {
        return new static("Sports Question {$index}");
    }
}