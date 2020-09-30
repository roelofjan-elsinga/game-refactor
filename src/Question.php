<?php

namespace App;

interface Question
{
    public function display(): string;

    public static function forIndex(int $index): Question;
}