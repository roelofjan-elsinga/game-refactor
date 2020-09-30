<?php


namespace App;


class PopQuestion extends BaseQuestion implements Question
{
    public static function forIndex(int $index): Question
    {
        return new static("Pop Question {$index}");
    }
}