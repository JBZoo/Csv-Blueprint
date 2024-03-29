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

use Respect\Validation\Validator;

final class IsPublicDomainSuffix extends AbstractCellRule
{
    public function getHelpMeta(): array
    {
        return [
            [],
            [
                self::DEFAULT => [
                    'true',
                    'The input is a public ICANN domain suffix. Example: "com", "nom.br", "net" etc.',
                ],
            ],
        ];
    }

    public function validateRule(string $cellValue): ?string
    {
        // @phpstan-ignore-next-line
        if (!Validator::oneOf(Validator::tld(), Validator::publicDomainSuffix())->validate($cellValue)) {
            return "The value \"<c>{$cellValue}</c>\" is not a valid public domain suffix. " .
                'Example: "com", "nom.br", "net" etc.';
        }

        return null;
    }
}
