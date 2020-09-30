<?php

declare(strict_types=1);

namespace App;


class Player
{

    private $current_place = 0;
    private $purse_balance = 0;
    private $in_penalty_box = false;
    private $will_be_released = false;
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function place(?int $current_place = null)
    {
        if (!is_null($current_place)) {
            $this->current_place = $current_place;

            return $this;
        }

        return $this->current_place;
    }

    public function purseBalance(?int $purse_balance = null)
    {
        if (!is_null($purse_balance)) {
            $this->purse_balance = $purse_balance;

            return $this;
        }

        return $this->purse_balance;
    }

    public function giveGold()
    {
        $current_balance = $this->purseBalance();

        $this->purseBalance($current_balance + 1);
    }

    public function inPenaltyBox()
    {
        return $this->in_penalty_box;
    }

    public function lockUp()
    {
        $this->in_penalty_box = true;

        return $this;
    }

    public function release()
    {
        $this->in_penalty_box = false;

        return $this;
    }

    public function name()
    {
        return $this->name;
    }

}