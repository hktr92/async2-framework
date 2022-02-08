<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')//    ->in(__DIR__ . '/tests')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        '@PSR12' => true,
        'class_attributes_separation' => ['elements' => ['method' => 'one']],
        'native_function_casing' => true,
        'native_function_type_declaration_casing' => true,
        'native_function_invocation' => ['include' => ['@internal'], 'scope' => 'namespaced'],
        'no_unused_imports' => true,
        'global_namespace_import' => ['import_constants' => true, 'import_functions' => true, 'import_classes' => true],
        'no_trailing_comma_in_singleline_array' => true,
        'no_trailing_comma_in_list_call' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays', 'arguments', 'parameters']],
        'no_blank_lines_after_phpdoc' => true,
        // TODO -- set this on true when this issue is closed: https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/5782
        'final_class' => false,
    ])
    ->setFinder($finder);
