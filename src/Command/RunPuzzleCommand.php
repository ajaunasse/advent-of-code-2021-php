<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Puzzle\Runnable;

final class RunPuzzleCommand extends Command
{

    const PUZZLE_NAMESPACE = 'App\\Puzzle\\';
    const INPUT_EXTENSION = '.txt';
    const INPUT_PATH = 'input/';

    protected static $defaultName = 'app:run:puzzle';

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows to run a puzzle in the Puzzle folder, `
            add a day and put the day of the puzzle in the parameters')

            ->addArgument('day',  InputArgument::REQUIRED, 'puzzle of the day (e.g day3')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $day = strtolower($input->getArgument('day'));

        $puzzleClass =  self::PUZZLE_NAMESPACE. ucfirst($day);
        $filePath = self::INPUT_PATH . $day . self::INPUT_EXTENSION;

        if (!class_exists($puzzleClass)) {
            $io->error($puzzleClass. ' class does not exist');
            return Command::FAILURE;
        }

        $input = $this->findInputData($filePath);

        if(empty($input)) {
            $io->error('input/' . $day . '.txt does not exist');
            return Command::FAILURE;
        }

        $runnablePuzzle = new $puzzleClass();

        if(!$runnablePuzzle instanceof Runnable) {
            $io->error(get_class($runnablePuzzle). ' should be an instance of '. Runnable::class);
            return Command::FAILURE;
        }

        $outputs = $runnablePuzzle->run($input);

        foreach ($outputs as $key => $output) {
            $io->success('Result '.++$key. ' = '. $output);
        }

        return Command::SUCCESS;

    }

    private function findInputData(string $filePath) : array
    {
       if(!file_exists($filePath)) {
           return [];
       }

        $content = file_get_contents($filePath);

        return explode(PHP_EOL, $content);
    }
}