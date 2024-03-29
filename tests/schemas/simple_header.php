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

return [
    'columns' => [
        [
            'name'  => 'seq',
            'rules' => [
                'not_empty' => true,
                'num_min'   => 2,
            ],
        ],
        [
            'name'  => 'bool',
            'rules' => [
                'not_empty' => true,
            ],
        ],
    ],
];
