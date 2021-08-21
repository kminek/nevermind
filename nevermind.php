<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/nevermind` package.
 */

require 'vendor/autoload.php';

use Kminek\Nevermind\Config;
use Kminek\Nevermind\Runner;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;

$app = new SingleCommandApplication();
$app
    ->addArgument(
        'name',
        InputArgument::REQUIRED,
        'Project name e.g. [todo] or [vendor/todo]'
    )
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        $name = $input->getArgument('name');

        $config = new Config([
            'name' => $name,
            'storage_dir' => __DIR__.'/storage',
        ]);

        $output->writeln(sprintf('Creating project [%s]', $name));

        $runner = new Runner($output, $config, [
            \Kminek\Nevermind\Task\CloneLaravel::class,
            \Kminek\Nevermind\Task\ComposerInstall::class,
            \Kminek\Nevermind\Task\FreezeDependencies::class,
            \Kminek\Nevermind\Task\ComposerInstall::class,
        ]);
        $runner->run();
    })
    ->run()
;
