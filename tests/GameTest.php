<?php

use App\ArrayWriter;
use App\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**@var Game $game*/
    private $game;

    public function setUp(): void
    {
        parent::setUp();

        $output_writer = new ArrayWriter();

        $this->game = new Game($output_writer);
    }

    public function test_game_without_players_is_not_playable()
    {
        $this->expectExceptionMessage("Not enough players to play this game.");

        $this->game->roll(1);
    }

    private function createPlayableGame()
    {
        $this->game->add("Player One");
        $this->game->add("Player Two");

        return $this->game;
    }

    public function test_game_is_playable_with_two_players()
    {
        $game = $this->createPlayableGame();

        $game->roll(1);

        $this->assertTrue(in_array("They have rolled a 1", $this->game->writer->messages));
    }

    public function test_number_of_players_is_equal_to_players_added()
    {
        $this->game = $this->createPlayableGame();

        $this->assertEquals(2, $this->game->howManyPlayers());
    }

    public function test_current_player_moves_when_rolling_dice()
    {
        $game = $this->createPlayableGame();

        $game->roll(5);

        $this->assertEquals(5, $game->getPlayer()->place());
        $this->assertTrue(in_array('They have rolled a 5', $this->game->writer->messages));
    }

    public function test_player_starts_from_the_start_after_12_steps()
    {
        $game = $this->createPlayableGame();

        $game->roll(6);
        $game->roll(4);
        $game->roll(4);

        $this->assertEquals(2, $game->getPlayer()->place());
    }

    public function test_current_player_lands_in_penalty_box_when_answering_incorrectly()
    {
        $game = $this->createPlayableGame();

        $this->assertFalse($game->getPlayer()->inPenaltyBox());

        // Current player will be changed to the next player in line
        $game->wrongAnswer();

        $this->assertTrue($game->previousPlayer()->inPenaltyBox());
    }

    public function test_player_gets_asked_correct_question_for_each_step()
    {
        $game = $this->createPlayableGame();

        $game->roll(0);
        $this->assertTrue(in_array('Pop Question 0', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Science Question 0', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Sports Question 0', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Rock Question 0', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Pop Question 1', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Science Question 1', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Sports Question 1', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Rock Question 1', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Pop Question 2', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Science Question 2', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Sports Question 2', $game->writer->messages));
        $game->roll(1);
        $this->assertTrue(in_array('Rock Question 2', $game->writer->messages));
    }

    public function test_player_gets_out_of_penalty_box_after_rolling_odd_number()
    {
        $game = $this->createPlayableGame();

        // Both players are in the penalty box
        $game->roll(1);
        $game->wrongAnswer();
        $game->roll(1);
        $game->wrongAnswer();
        $game->roll(3);

        $this->assertFalse($game->getPlayer()->inPenaltyBox());
        $this->assertTrue(in_array("Player One is getting out of the penalty box", $game->writer->messages));
    }

    public function test_player_stays_in_the_penalty_box_after_even_dice_roll()
    {
        $game = $this->createPlayableGame();

        // Both players are in the penalty box
        $game->roll(1);
        $game->wrongAnswer();
        $game->roll(1);
        $game->wrongAnswer();
        $game->roll(4);

        $this->assertTrue($game->getPlayer()->inPenaltyBox());
        $this->assertTrue(in_array("Player One is not getting out of the penalty box", $game->writer->messages));
    }

    public function test_player_in_penalty_box_does_not_get_points_for_correct_answers()
    {
        $game = $this->createPlayableGame();

        // Both players are in the penalty box
        $game->roll(1);
        $game->wrongAnswer();
        $game->roll(1);
        $game->wrongAnswer();
        $game->roll(4);
        $game->wasCorrectlyAnswered(); // Switches to next player

        $this->assertEquals(0, $game->previousPlayer()->purseBalance());
    }

    public function test_player_outside_penalty_box_does_get_points_for_correct_answers()
    {
        $game = $this->createPlayableGame();

        $game->roll(1);
        $game->wasCorrectlyAnswered();

        $this->assertEquals(1, $game->previousPlayer()->purseBalance());
    }

}