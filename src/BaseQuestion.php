<?php


namespace App;


abstract class BaseQuestion
{
    private $question;

    protected function __construct(string $question)
    {
        $this->question = $question;
    }

    public function display(): string
    {
        return $this->question;
    }
}