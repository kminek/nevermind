<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/nevermind` package.
 */

namespace Kminek\Nevermind;

final class Config
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getStorageDir(): string
    {
        return $this->data['storage_dir'];
    }
}
