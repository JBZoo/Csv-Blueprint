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

namespace JBZoo\CsvBlueprint\Rules\Cell;

final class IsBool extends AllowValues
{
    protected const HELP_OPTIONS = [
        self::DEFAULT => ['true', 'Allow only boolean values "true" and "false", case-insensitive'],
    ];

    public function validateRule(string $cellValue): ?string
    {
        return parent::validateRule(\strtolower($cellValue));
    }

    public function getOptionAsArray(): array
    {
        return ['true', 'false'];
    }
}
