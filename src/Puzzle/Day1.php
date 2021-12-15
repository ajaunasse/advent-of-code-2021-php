<?php

namespace App\Puzzle;

final class Day1 implements Runnable
{
    private int $numberOfStars = 0;

    public function run(array $input): array
    {
        $data = array_map('intval', $input);

        $this->numberOfStars = count($data);

        return [
            $this->resolvePart1($data),
            $this->resolvePart2($data)
        ];
    }

    public function resolvePart1(array $data): int
    {
        $previousLine = PHP_INT_MAX;
        $singleIncrement = 0;

        for($i= 0; $i < $this->numberOfStars; $i++){
            $currentLine = $data[$i];

            if($previousLine < $currentLine) {
                $singleIncrement++;
            }

            $previousLine = $currentLine;
        }

        return $singleIncrement;
    }

    public function resolvePart2(array $data): int
    {
        $previousWindows = PHP_INT_MAX;
        $windowsIncrement = 0;

        for($i= 0; $i < $this->numberOfStars; $i++){

            if($i > $this->numberOfStars - 2) {
                continue;
            }

            $currentWindows = $data[$i] + $data[$i+1] +  $data[$i+2];

            if($previousWindows < $currentWindows) {
                $windowsIncrement++;
            }

            $previousWindows = $currentWindows;
        }

        return $windowsIncrement;
    }
}