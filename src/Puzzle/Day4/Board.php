<?php

namespace App\Puzzle\Day4;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;

class Board
{
    private ArrayCollection $lines;

    public function __construct(private bool $winner = false, private int $rank = 0){
        $this->lines = new ArrayCollection();
    }

    public function addLine(Line $line)
    {
        $this->lines->add($line);
    }

    public function lines(): ArrayCollection
    {
        return $this->lines;
    }

    public function isWinner(): bool
    {
        return $this->winner;
    }

    public function findLineWithValue(int $value): ?Line
    {
        $expression = new Comparison('value', '=', $value);

        $criteria = new Criteria($expression);

        $matched = $this->lines->matching($criteria);

        if($matched->isEmpty()) {
            return null;
        }

        return $matched->first();
    }

    public function hasACompletedRow(): bool
    {
        $filterLines = $this->getMarkedLines();

        if($filterLines->count() < 5) {
            return false;
        }

        for($i = 1; $i <= 5; $i++) {
            $filterRowLines = $filterLines->filter(function (Line $line) use ($i) {
                return $line->x() === $i;
            });

            $filterColumnLines = $filterLines->filter(function (Line $line) use ($i) {
                return $line->y() === $i;
            });


            if($filterRowLines->count() === 5 || $filterColumnLines->count() === 5) {
                return true;
            }
        }

        return false;
    }

    public function getMarkedLines(): ?ArrayCollection
    {
        return $this->lines->filter(function (Line $line) {
            return $line->isMarked();
        });
    }

    public function getUnmarkedLine(): ?ArrayCollection
    {
        return $this->lines->filter(function (Line $line) {
            return !$line->isMarked();
        });
    }

    public function sumUnmarkedLine(): int
    {
        $sum = 0;
        $unmarkedLines = $this->getUnmarkedLine();

        foreach ($unmarkedLines as $line) {
            /** @var Line $line */
            $sum += $line->getValue();
        }

        return $sum;
    }

    public function win(): void
    {
        $this->winner = true;
    }

    public function setRank(int $rank): void
    {
        $this->rank = $rank;
    }

    public function getRank(): int
    {
        return $this->rank;
    }
}