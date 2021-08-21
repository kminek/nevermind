<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/nevermind` package.
 */

namespace Kminek\Nevermind;

/*
 * This file is part of the `kminek/nevermind` package.
 */

use Kminek\Nevermind\Task\AbstractTask;
use Symfony\Component\Console\Output\OutputInterface;

final class Runner
{
    /**
     * @var AbstractTask[]
     */
    private array $tasks;

    public function __construct(
        OutputInterface $output,
        Config $config,
        array $taskClasses
    ) {
        foreach ($taskClasses as $taskClass) {
            $this->tasks[] = new $taskClass($config, $output);
        }
    }

    public function run(): void
    {
        foreach ($this->tasks as $task) {
            $task->run();
        }
    }
}
