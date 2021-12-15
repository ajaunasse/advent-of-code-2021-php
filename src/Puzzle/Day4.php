<?php

namespace App\Puzzle;

use App\Puzzle\Day4\Board;
use App\Puzzle\Day4\Line;
use Doctrine\Common\Collections\ArrayCollection;

final class Day4 implements Runnable
{
    private array $game = [];

    private ArrayCollection $boards ;

    public function run(array $input): array
    {
        return [
            $this->resolvePart1($input),
            $this->resolvePart2($input)
        ];
    }

    public function resolvePart1(array $data): int
    {
        $this->initGame($data);
        $currentBoard = new Board();
        $value = 0;

        foreach ($this->game as $key => $value) {

            foreach ($this->boards as $currentBoard) {
                /** @var Board $currentBoard */
                $line = $currentBoard->findLineWithValue($value);

                $line?->marke();

                //We do not check result if there are less than 5 number in the game
                if($key < 4) {
                    continue;
                }

                if($currentBoard->hasACompletedRow()) {
                    $currentBoard->win();
                    break;
                }
            }

            if($currentBoard->isWinner()){
                break;
            }
        }

       return $currentBoard->sumUnmarkedLine() * $value;
    }


    public function resolvePart2(array $data): int
    {
        $this->initGame($data);
        $value = 0;
        $rank = 0;
        $numberOfBoard = $this->boards->count();

        $gameIsFinished = false;

        foreach ($this->game as $key => $value) {

            foreach ($this->boards as $currentBoard) {
                /** @var Board $currentBoard */
                $line = $currentBoard->findLineWithValue($value);

                $line?->marke();

                //We do not check result if there are less than 5 number in the game
                if($key < 4) {
                    continue;
                }

                if($currentBoard->isWinner()) {
                    continue;
                }

                if($currentBoard->hasACompletedRow()) {
                    $currentBoard->win();
                    ++$rank;
                    $currentBoard->setRank($rank);
                }


                if($rank === $numberOfBoard) {
                    $gameIsFinished = true;
                    break;
                }
            }

            if($gameIsFinished) {
                break;
            }
        }

        $lastWinner = $this->boards->filter(function (Board $board) use ($rank) {
           return $board->getRank() === $rank;
        })->first();

        return $lastWinner->sumUnmarkedLine() * $value;
    }

    private function initGame(array $data): void
    {
        $this->boards = new ArrayCollection();
        //First line of the data is the game
        $this->game = array_map('intval', explode(',', $data[0]));

        $board = new Board();
        $lineNumber = 1;

        foreach ($data as $key => $value) {

            //First line is the game
            if($key === 0) {
                $this->game = array_map('intval', explode(',', $value));
                continue;
            }

            if($key === 1) {
                continue;
            }

            if($value === '') {
                $this->boards->add($board);
                $board = new Board();
                $lineNumber = 1;

                continue;
            }

            $value = str_replace('  ', ' ', $value);
            $currentLine = array_map('intval', explode(' ', $value));

            foreach ($currentLine as $k => $val) {
                $line = new Line($lineNumber, ++$k, $val);
                $board->addLine($line);
            }

            $lineNumber++;
        }
    }
}