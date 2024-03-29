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

use JBZoo\CsvBlueprint\Rules\AbstarctRule;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class AbstractCellRule extends AbstarctRule
{
    /**
     * Validate the rule.
     * This method takes a string $cellValue as input and returns a nullable string.
     */
    abstract public function validateRule(string $cellValue): ?string;

    public function test(string $cellValue, bool $isHtml = false): string
    {
        $errorMessage = (string)$this->validateRule($cellValue);

        return $isHtml ? $errorMessage : \strip_tags($errorMessage);
    }
}
