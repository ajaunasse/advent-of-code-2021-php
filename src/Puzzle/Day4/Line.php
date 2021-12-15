<?php
declare(strict_types=1);

namespace App\Puzzle\Day4;

final class Line
{

    public function __construct(
        private int $x,
        private int $y,
        private int $value,
        private bool $marked = false
    ) {
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function position(): array
    {
        return [$this->x, $this->y];
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isMarked(): bool
    {
        return $this->marked;
    }

    public function marke() : void
    {
        $this->marked = true;
    }
}