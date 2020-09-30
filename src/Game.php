<?php

declare(strict_types=1);

namespace App;

class Game {

    /**@var Player[] $players*/
    private $players = [];

    /**@var QuestionRepository $questions*/
    private $questions;

    private $current_player = 0;

    /**@var OutputWriter $writer*/
    public $writer;

    public function  __construct(?OutputWriter $writer = null) {
        $this->writer = $writer ?? new EchoWriter();

        $this->questions = new QuestionRepository();
    }

    private function isPlayable(): bool
    {
        return ($this->howManyPlayers() >= 2);
    }

    public function add(string $playerName): void
    {
        $player = new Player($playerName);

        array_push($this->players, $player);

        $this->showMessage("{$player->name()} was added");
        $this->showMessage("They are player number {$this->howManyPlayers()}");
    }

    public function howManyPlayers(): int
    {
        return count($this->players);
    }

    public function roll($roll): void
    {
        if (!$this->isPlayable()) {
            throw new \Exception("Not enough players to play this game.");
        }

        $current_player = $this->getPlayer();

        $this->showMessage("{$current_player->name()} is the current player");
        $this->showMessage("They have rolled a {$roll}");

        if ($current_player->inPenaltyBox()) {
            if ($this->isOddRoll($roll)) {
                $this->showMessage("{$current_player->name()} is getting out of the penalty box");
                $current_player->release();
            } else {
                $this->showMessage("{$current_player->name()} is not getting out of the penalty box");
                return;
            }
        }

        $this->setNewPlaceAfterRoll($roll);

        $this->showMessage("{$current_player->name()}'s new location is {$current_player->place()}");
        $this->showMessage("The category is {$this->questions->currentCategory($current_player)}");
        $this->askQuestion();

    }

    private function askQuestion(): void
    {
        $question = $this->questions->askToPlayer($this->getPlayer());

        $this->showMessage($question);
    }

    public function wasCorrectlyAnswered(): bool
    {
        $current_player = $this->getPlayer();

        if ($current_player->inPenaltyBox()) {

            $this->setNextPlayer();

            return true;
        }

        $this->showMessage("Answer was correct!!!!");
        $current_player->giveGold();
        $this->showMessage("{$current_player->name()} now has {$current_player->purseBalance()} Gold Coins.");

        $is_still_playing = $this->isStillPlaying();

        $this->setNextPlayer();

        return $is_still_playing;
    }

    public function wrongAnswer(): bool
    {
        $current_player = $this->getPlayer();

        $this->showMessage("Question was incorrectly answered");
        $this->showMessage("{$current_player->name()} was sent to the penalty box");
        $current_player->lockUp();

        $this->setNextPlayer();

        return true;
    }

    private function isStillPlaying(): bool
    {
        return $this->getPlayer()->purseBalance() != 6;
    }

    private function showMessage(string $message): void
    {
        $this->writer->write($message);
    }

    private function setNextPlayer(): void
    {
        $this->current_player++;

        if ($this->current_player == count($this->players)) {
            $this->current_player = 0;
        }
    }

    /**
     * @param $roll
     */
    private function setNewPlaceAfterRoll($roll): void
    {
        $current_place = $this->getPlayer()->place();

        $new_place = $current_place + $roll;

        if ($new_place > 11) {
            $new_place = $new_place - 12;
        }

        $this->getPlayer()->place($new_place);
    }

    /**
     * @param $roll
     * @return bool
     */
    private function isOddRoll($roll): bool
    {
        return $roll % 2 != 0;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->players[$this->current_player];
    }

    public function previousPlayer(): Player
    {
        $previous_index = $this->current_player - 1 !== -1
            ? $this->current_player - 1
            : count($this->players) - 1;

        return $this->players[$previous_index];
    }
}