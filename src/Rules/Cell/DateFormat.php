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

final class DateFormat extends AbstractCellRule
{
    public function getHelpMeta(): array
    {
        return [
            [],
            [self::DEFAULT => ['Y-m-d', 'Check strict format of the date.']],
        ];
    }

    public function validateRule(string $cellValue): ?string
    {
        if ($cellValue === '') {
            return null;
        }

        $expectedDateFormat = $this->getOptionAsString();
        if ($expectedDateFormat === '') {
            return 'Date format is not defined';
        }

        $date = \DateTimeImmutable::createFromFormat($expectedDateFormat, $cellValue);
        if ($date === false || $date->format($expectedDateFormat) !== $cellValue) {
            return "Date format of value \"<c>{$cellValue}</c>\" is not valid. " .
                "Expected format: \"<green>{$expectedDateFormat}</green>\"";
        }

        return null;
    }
}
