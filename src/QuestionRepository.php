<?php

declare(strict_types=1);

namespace App;


class QuestionRepository
{
    /**@var Question $popQuestions*/
    private $popQuestions = [];
    /**@var Question $popQuestions*/
    private $scienceQuestions = [];
    /**@var Question $popQuestions*/
    private $sportsQuestions = [];
    /**@var Question $popQuestions*/
    private $rockQuestions = [];

    public function __construct()
    {
        for ($i = 0; $i < 50; $i++) {
            array_push($this->popQuestions, PopQuestion::forIndex($i));
            array_push($this->scienceQuestions, ScienceQuestion::forIndex($i));
            array_push($this->sportsQuestions, SportsQuestion::forIndex($i));
            array_push($this->rockQuestions, RockQuestion::forIndex($i));
        }
    }

    public function askToPlayer(Player $player): string
    {
        switch($this->currentCategory($player)) {
            case "Pop":
                return array_shift($this->popQuestions)->display();
            case "Science":
                return array_shift($this->scienceQuestions)->display();
            case "Sports":
                return array_shift($this->sportsQuestions)->display();
            default:
                return array_shift($this->rockQuestions)->display();
        }
    }

    public function currentCategory(Player $current_player): string
    {
        $categories = [
            "Pop", "Science", "Sports", "Rock",
            "Pop", "Science", "Sports", "Rock",
            "Pop", "Science", "Sports", "Rock",
        ];

        return $categories[$current_player->place()];
    }
}