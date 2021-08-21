<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/nevermind` package.
 */

namespace Kminek\Nevermind\Task;

final class ComposerInstall extends AbstractTask
{
    public function payload(): void
    {
        $this->process([
            'rm',
            '-rf',
            'composer.lock',
        ], $this->config->getStorageDir());

        $this->process([
            'rm',
            '-rf',
            'vendor/',
        ], $this->config->getStorageDir());

        $this->process([
            'composer',
            'install',
        ], $this->config->getStorageDir());
    }
}
