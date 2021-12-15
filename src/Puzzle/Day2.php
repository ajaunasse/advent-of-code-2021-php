<?php

namespace App\Puzzle;

final class Day2 implements Runnable
{
    const UP = 'up';
    const DOWN =  'down';
    const FORWARD = 'forward';

    private int $horizontalPosition = 0 ;

    private int $depth = 0;

    private int $aim = 0;

    public function run(array $input): array
    {
        return [
            $this->resolvePart1($input),
            $this->resolvePart2($input)
        ];
    }

    public function resolvePart1(array $data): int
    {
        for($i=0; $i < count($data); $i++)
        {

            [$instruction, $value] = explode(' ', $data[$i]) ;
            $value = intval($value);

            match ($instruction) {
                self::UP => $this->up($value),
                self::DOWN => $this->down($value),
                self::FORWARD => $this->forward($value,)
            };
        }

        return  $this->horizontalPosition * $this->depth;
    }


    public function resolvePart2(array $data): int
    {
        $this->reset();

        for($i=0; $i < count($data); $i++)
        {

            [$instruction, $value] = explode(' ', $data[$i]) ;
            $value = intval($value);

            match ($instruction) {
                self::UP => $this->upAim($value),
                self::DOWN => $this->downAim($value),
                self::FORWARD => $this->forward($value, true)
            };
        }

        return  $this->horizontalPosition * $this->depth;
    }

    //Only for part1
    private function up(int $value): void {
        $this->depth -= $value;
    }

    //Only for part1
    private function down(int $value): void {
        $this->depth += $value;
    }

    //Only for part2
    private function upAim(int $value): void {
        $this->aim -= $value;
    }

    //Only for part2
    private function downAim(int $value): void {
        $this->aim += $value;
    }

    //Only for part2
    private function updateDepth(int $value): void {
        $this->depth += $this->aim * $value;
    }

    private function forward(int $value, bool $updateDepth = false): void {
        $this->horizontalPosition += $value;

        //Only for part2
        if($updateDepth) {
            $this->updateDepth($value);
        }
    }

    private function reset() {
        $this->horizontalPosition = 0;
        $this->depth = 0;
        $this->aim = 0;
    }

}