<?php
declare(strict_types=1);

namespace App\Puzzle;

interface Runnable
{
    public function run(array $input): array;

    public function resolvePart1(array $data): int;

    public function resolvePart2(array $data): int;
}