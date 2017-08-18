<?php

use Sami\Sami;
// Componente desenvolvido pela Sensiolabs, para encontrar arquivos e diretórios http://symfony.com/doc/current/components/finder.html
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('docs')
    ->exclude('database')
    ->in(__DIR__ . '/../');

$configuration = [
    'theme' => 'default',
    'title' => 'PHPag Docs',
    'build_dir' => __DIR__ . '/build',
    'cache_dir' => __DIR__ . '/cache',
];

return new Sami($iterator, $configuration);