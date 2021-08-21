<?php

$header = <<<EOT
This file is part of the `kminek/nevermind` package.
EOT;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
return $config
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setRules([
        '@Symfony' => true,
        'declare_strict_types' => true,
        'strict_param' => true,
        'ordered_imports' => true,
        'header_comment' => [
            'header' => $header,
        ],
    ])
    ->setFinder($finder)
;
