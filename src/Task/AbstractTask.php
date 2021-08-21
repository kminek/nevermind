<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/nevermind` package.
 */

namespace Kminek\Nevermind\Task;

use Kminek\Nevermind\Config;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

abstract class AbstractTask
{
    protected Config $config;

    protected OutputInterface $output;

    public function __construct(Config $config, OutputInterface $output)
    {
        $this->config = $config;
        $this->output = $output;
    }

    public function run(): void
    {
        $this->output->writeln(sprintf('Running task [%s]', static::class));
        $this->payload();
    }

    abstract protected function payload(): void;

    protected function process(array $command, ?string $cwd = null): Process
    {
        $process = new Process($command);

        if (null !== $cwd) {
            $process->setWorkingDirectory($cwd);
        }

        $process->setTimeout(null);
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process;
    }

    protected function lastVersion(string $project): string
    {
        $process = $this->process([
            'lastversion',
            $project,
        ]);

        return trim($process->getOutput());
    }
}
