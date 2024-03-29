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

namespace JBZoo\PHPUnit\Rules\Cell;

use JBZoo\CsvBlueprint\Rules\Cell\IsFloat;
use JBZoo\PHPUnit\Rules\TestAbstractCellRule;

use function JBZoo\PHPUnit\isSame;

final class IsFloatTest extends TestAbstractCellRule
{
    protected string $ruleClass = IsFloat::class;

    public function testPositive(): void
    {
        $rule = $this->create(true);
        isSame('', $rule->test(''));
        isSame('', $rule->test('1'));
        isSame('', $rule->test('01'));
        isSame('', $rule->test('1.0'));
        isSame('', $rule->test('01.0'));
        isSame('', $rule->test('.0'));
        isSame('', $rule->test('.1'));
        isSame('', $rule->test('-1'));
        isSame('', $rule->test('-1.0'));
        isSame('', $rule->test('1e5'));
        isSame('', $rule->test('1E5'));
        isSame('', $rule->test(' 1E5'));

        $rule = $this->create(false);
        isSame(null, $rule->validate(' q'));
    }

    public function testNegative(): void
    {
        $rule = $this->create(true);
        isSame(
            'Value "1.000.000" is not a float number',
            $rule->test('1.000.000'),
        );
        isSame(
            'Value "1.000 000" is not a float number',
            $rule->test('1.000 000'),
        );
        isSame(
            'Value " q" is not a float number',
            $rule->test(' q'),
        );
    }
}
