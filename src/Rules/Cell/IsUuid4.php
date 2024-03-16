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

final class IsUuid4 extends AbstarctCellRule
{
    protected const HELP_OPTIONS = [
        self::DEFAULT => ['__', '__'],
    ];

    public function validateRule(string $cellValue): ?string
    {
        $uuid4 = '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89ABab][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/';

        if (\preg_match($uuid4, $cellValue) === 0) {
            return 'Value is not a valid UUID v4';
        }

        return null;
    }
}
