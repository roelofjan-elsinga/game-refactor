<?php


namespace App;


class ScienceQuestion extends BaseQuestion implements Question
{
    public static function forIndex(int $index): Question
    {
        return new static("Science Question {$index}");
    }
}