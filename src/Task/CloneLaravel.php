<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/nevermind` package.
 */

namespace Kminek\Nevermind\Task;

final class CloneLaravel extends AbstractTask
{
    public function payload(): void
    {
        $this->process([
            'git',
            'clone',
            'https://github.com/laravel/laravel.git',
            '.',
        ], $this->config->getStorageDir());

        $this->process([
            'git',
            'checkout',
            'v'.$this->lastVersion('laravel/laravel'),
        ], $this->config->getStorageDir());
    }
}
