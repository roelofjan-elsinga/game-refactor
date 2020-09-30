<?php

declare(strict_types=1);

namespace App;


class ScienceQuestion extends BaseQuestion implements Question
{
    public static function forIndex(int $index): Question
    {
        return new static("Science Question {$index}");
    }
}