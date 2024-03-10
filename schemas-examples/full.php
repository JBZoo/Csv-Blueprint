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

# It's a full example of the CSV schema file in PHP format.

return [
    'csv_structure' => [
        'header'     => true,
        'delimiter'  => ',',
        'quote_char' => '\\',
        'enclosure'  => '"',
        'encoding'   => 'utf-8',
        'bom'        => false,
    ],
    'columns' => [
        [
            'name'        => 'csv header name',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'rules'       => [
                'allow_values'       => ['y', 'n', ''],
                'date_format'        => 'Y-m-d',
                'exact_value'        => 'Some string',
                'is_bool'            => true,
                'is_domain'          => true,
                'is_email'           => true,
                'is_float'           => true,
                'is_int'             => true,
                'is_ip'              => true,
                'is_latitude'        => true,
                'is_longitude'       => true,
                'is_url'             => true,
                'is_uuid4'           => true,
                'min'                => 10,
                'max'                => 100,
                'min_length'         => 1,
                'max_length'         => 10,
                'min_date'           => '2000-01-02',
                'max_date'           => 'now',
                'not_empty'          => true,
                'only_capitalize'    => true,
                'only_lowercase'     => true,
                'only_uppercase'     => true,
                'only_trimed'        => true,
                'precision'          => 2,
                'regex'              => '/^[\\d]{2}$/',
                'cardinal_direction' => true,
                'usa_market_name'    => true,
            ],
        ],
    ],
];
