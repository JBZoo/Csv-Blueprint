<?php

/**
 * JBZoo Toolbox - Csv-Blueprint.
 *
 * This file is part of the JBZoo Toolbox project.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT
 * @copyright  Copyright (C) JBZoo.com, All rights reserved.
 * @see        https://github.com/JBZoo/Csv-Blueprint
 */

declare(strict_types=1);

namespace JBZoo\Codestyle\PhpCsFixer;

return (new PhpCsFixerCodingStandard(__DIR__))->getFixerConfig(null, [
    'binary_operator_spaces' => [
        'operators' => [
            '='  => 'single_space',
            '=>' => 'align_single_space_minimal',
        ],
    ],
    'blank_line_before_statement' => [
        'statements' => [
            'case',
            'default',
            'declare',
            'do',
            'for',
            'switch',
            'try',
            'while',
            'phpdoc',
        ],
    ],
]);
