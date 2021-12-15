<?php

require __DIR__.'/vendor/autoload.php';

use App\Command\RunPuzzleCommand;
use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$application->add(new RunPuzzleCommand());

$application->run();