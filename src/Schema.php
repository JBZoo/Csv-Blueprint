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

namespace JBZoo\CsvBlueprint;

use JBZoo\CsvBlueprint\Csv\Column;
use JBZoo\CsvBlueprint\Csv\ParseConfig;
use JBZoo\CsvBlueprint\Validators\ErrorSuite;
use JBZoo\CsvBlueprint\Validators\ValidatorSchema;
use JBZoo\Data\AbstractData;
use JBZoo\Data\Data;

use function JBZoo\Data\json;
use function JBZoo\Data\phpArray;
use function JBZoo\Data\yml;

final class Schema
{
    private ?string      $filename;
    private AbstractData $data;

    /** @var Column[] */
    private array $columns;

    public function __construct(null|array|string $csvSchemaFilenameOrArray = null)
    {
        if (\is_array($csvSchemaFilenameOrArray)) {
            $this->filename = '_custom_array_';
            $this->data = new Data($csvSchemaFilenameOrArray);
        } elseif (
            \is_string($csvSchemaFilenameOrArray)
            && $csvSchemaFilenameOrArray !== ''
            && \file_exists($csvSchemaFilenameOrArray)
        ) {
            $this->filename = $csvSchemaFilenameOrArray;
            $this->data = new Data();
            $fileExtension = \pathinfo($csvSchemaFilenameOrArray, \PATHINFO_EXTENSION);

            if ($fileExtension === 'yml' || $fileExtension === 'yaml') {
                $this->data = yml($csvSchemaFilenameOrArray);
            } elseif ($fileExtension === 'json') {
                $this->data = json($csvSchemaFilenameOrArray);
            } elseif ($fileExtension === 'php') {
                $this->data = phpArray($csvSchemaFilenameOrArray);
            } else {
                throw new \InvalidArgumentException("Unsupported file extension: {$fileExtension}");
            }
        } elseif (\is_string($csvSchemaFilenameOrArray)) {
            throw new \InvalidArgumentException("Invalid schema data: {$csvSchemaFilenameOrArray}");
        } else {
            $this->filename = null;
            $this->data = new Data();
        }

        $this->columns = $this->prepareColumns();
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function getCsvStructure(): ParseConfig
    {
        return new ParseConfig($this->data->getArray('csv'));
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return Column[]|null[]
     * @phan-suppress PhanPartialTypeMismatchReturn
     */
    public function getColumnsMappedByHeader(array $header): array
    {
        $map = [];

        if ($this->getCsvStructure()->isHeader()) {
            foreach ($header as $headerName) {
                $map[$headerName] = $this->columns[$headerName] ?? null;
            }
        } else {
            return $this->getColumns();
        }

        return $map;
    }

    public function getColumn(int|string $columNameOrId): ?Column
    {
        if (\is_int($columNameOrId)) {
            $column = \array_values($this->getColumns())[$columNameOrId] ?? null;
        } else {
            $column = $this->getColumns()[$columNameOrId] ?? null;
        }

        if ($column === null) {
            throw new Exception("Column \"{$columNameOrId}\" not found in schema \"{$this->filename}\"");
        }

        return $column;
    }

    public function getFilenamePattern(): ?string
    {
        return Utils::prepareRegex($this->data->getStringNull('filename_pattern'));
    }

    public function getIncludes(): array
    {
        $result = [];

        foreach ($this->data->getArray('includes') as $includedPath) {
            [$schemaPath, $alias] = \explode(' as ', $includedPath);

            $schemaPath = \trim($schemaPath);
            $alias = \trim($alias);

            $result[$alias] = $schemaPath;
        }

        return $result;
    }

    public function validate(bool $quickStop = false): ErrorSuite
    {
        return (new ValidatorSchema($this))->validate($quickStop);
    }

    /**
     * Clone data to avoid any external side effects.
     */
    public function getData(): AbstractData
    {
        return clone $this->data;
    }

    /**
     * @return Column[]
     */
    private function prepareColumns(): array
    {
        $result = [];

        foreach ($this->data->getArray('columns') as $columnId => $columnPreferences) {
            $column = new Column((int)$columnId, $columnPreferences);

            $result[$column->getKey()] = $column;
        }

        return $result;
    }
}
