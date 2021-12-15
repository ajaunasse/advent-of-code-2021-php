<?php

namespace App\Puzzle;

final class Day3 implements Runnable
{
    public function run(array $input): array
    {
        return [
            $this->resolvePart1($input),
            $this->resolvePart2($input)
        ];
    }

    public function resolvePart1(array $data): int
    {
        $gamma = $epsilon = '';

        $bits = $this->countOccurence($data);

        foreach ($bits as $value) {
            ;
            if ($value['1'] > $value['0']) {
                $gamma .= '1';
                $epsilon .= '0';
            } else {
                $gamma .= '0';
                $epsilon .= '1';
            }
        }

        return bindec($gamma) * bindec($epsilon);
    }


    public function resolvePart2(array $data): int
    {
        $oxygens = $this->reduceBits($data);
        $co2s = $this->reduceBits($data, '0', '1', '0', false);

        $oxygen = array_values($oxygens)[0];
        $co2 = array_values($co2s)[0];

        return bindec($oxygen) * bindec($co2);
    }

    private function countOccurence(array $arrayToCount): array
    {
        $occurencePerBits = [];

        foreach ($arrayToCount as $line) {
            if($line === '') {
                continue;
            }


            foreach (str_split($line) as  $index => $binary) {

                if(!isset($occurencePerBits[$index])) {
                    $occurencePerBits[$index]['0'] = 0;
                    $occurencePerBits[$index]['1'] = 0;
                }

                if($binary === '0') {
                    $occurencePerBits[$index]['0'] += 1;
                } else {
                    $occurencePerBits[$index]['1'] += 1;
                }
            }

        }
        return $occurencePerBits;
    }

    private function filterValue(array $arrayToFilter, int $position, string $value): array
    {
        if(count($arrayToFilter) === 1) {
            return $arrayToFilter;
        }

        return array_filter($arrayToFilter, function ($item) use ($position, $value) {
            return $item[$position] === $value;
        });
    }

    private function reduceBits(array $data, string $valueBetterThan = '1', string $valueLessThan = '0', string $defaultValue= '1', bool $mostCommonBit = true)
    {
        $currentPosition = 0 ;
        while(count($data) > 1) {

            $bitsOccurence = $this->countOccurence($data);
            $currentBit = $bitsOccurence[$currentPosition];
            if($currentBit[$valueBetterThan] === $currentBit[$valueLessThan]){
                $data = $this->filterValue($data, $currentPosition, $defaultValue);
                $currentPosition++;
                continue;
            }

            if($currentBit[$valueBetterThan] >= $currentBit[$valueLessThan]) {
                if($mostCommonBit) {
                    $data = $this->filterValue($data, $currentPosition, $valueBetterThan);
                } else {
                    $data = $this->filterValue($data, $currentPosition, $valueLessThan);
                }
            } else {
                if($mostCommonBit) {
                    $data = $this->filterValue($data, $currentPosition, $valueLessThan);
                } else {
                    $data = $this->filterValue($data, $currentPosition, $valueBetterThan);
                }
            }

            $currentPosition++;
        }

        return $data;
    }
}