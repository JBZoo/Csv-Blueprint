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

namespace JBZoo\CsvBlueprint\CellRules;

final class MaxWordCount extends AbstarctCellRule
{
    public function validateRule(string $cellValue): ?string
    {
        $wordCount = $this->getOptionAsInt();
        $count     = \str_word_count($cellValue);

        if ($count > $wordCount) {
            return "Value \"<c>{$cellValue}</c>\" has {$count} words, " .
                "but must have no more than <green>{$wordCount}</green> words";
        }

        return null;
    }
}