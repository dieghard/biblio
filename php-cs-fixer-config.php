<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

// Configuración de reglas personalizada
$rules = [
    'indentation_type' => true, // Utilizar sangrado con espacios
    'line_ending' => true, // Utilizar fin de línea LF en lugar de CRLF
    // Otras reglas personalizadas aquí...
];

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude('vendor');

$config = new Config();
$config
    ->setRules($rules)
    ->setFinder($finder);

return $config;
