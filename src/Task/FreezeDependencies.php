<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/nevermind` package.
 */

namespace Kminek\Nevermind\Task;

class FreezeDependencies extends AbstractTask
{
    protected function payload(): void
    {
        $composerJson = json_decode(
            file_get_contents($this->config->getStorageDir().'/composer.json'),
            true
        );

        $composerJson['name'] = $this->config->getName();
        $composerJson['license'] = 'proprietary';

        $p = $this->process([
            'composer',
            'show',
            '--direct',
            '--format=json',
        ], $this->config->getStorageDir());
        $installed = json_decode($p->getOutput(), true);

        foreach ($composerJson['require'] as $package => $version) {
            foreach ($installed['installed'] as $installedPackage) {
                if ($installedPackage['name'] === $package) {
                    $composerJson['require'][$package] = ltrim($installedPackage['version'], 'v');
                    break;
                }
            }
        }

        foreach ($composerJson['require-dev'] as $package => $version) {
            foreach ($installed['installed'] as $installedPackage) {
                if ($installedPackage['name'] === $package) {
                    $composerJson['require-dev'][$package] = ltrim($installedPackage['version'], 'v');
                    break;
                }
            }
        }

        file_put_contents(
            $this->config->getStorageDir().'/composer.json',
            json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL
        );
    }
}
