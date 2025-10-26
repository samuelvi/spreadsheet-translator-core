<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Parser;

use Iterator;

class DataParser extends AbstractParser implements Iterator
{
    public function __construct($data, $rowHeader, $firstRow, $nameSeparator)
    {
        $this->rowHeader = $rowHeader;
        $this->firstRow = $firstRow;
        $this->nameSeparator = $nameSeparator;

        $this->index = $this->firstRow;
        $this->data = $data;
        $this->header = $this->data[$this->rowHeader];

        $this->configureKeyColumns();
        $this->configureLocaleColumns();
    }

    public function getData()
    {
        return $this->data;
    }


    public function current(): mixed
    {
        return $this;
    }


    public function next(): void
    {
        $this->index++;
    }

    public function key(): mixed
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return (count($this->data) > ($this->index));
    }

    public function rewind(): void
    {
        $this->index = $this->firstRow + 1;
    }

    public function count(): int
    {
        return count($this->data);
    }

    protected function configureKeyColumns()
    {
        for ($i = 0, $count = count($this->header); $i < $count; $i++) {
            $key = $this->header[$i];

            if (empty($key) || $this->isValidLocale($key)) {
                break;
            }
            $this->nameColumns[$key] = $i;
        }
    }
    
    private function isValidLocale($locale): int|false
    {
        return preg_match('/^([a-z]{2})((-|_)[A-Z]{2})?$/', (string) $locale);
    }

    protected function configureLocaleColumns()
    {
        for ($i = 0, $count = count($this->header); $i < $count; $i++) {
            $locale = $this->header[$i];
            if ($this->isValidLocale($locale)) {
                $this->localeColumns[$locale] = $i;
            }
        }
    }

    public function resolveKey()
    {
        $keys = [];
        for ($i = 0, $count = count($this->nameColumns); $i < $count; $i++) {
            $keys[] = $this->data[$this->index][$i];
        }

        return $this->buildKey($keys);
    }

    /**
     * @return mixed[]
     */
    public function resolveLazyKeys($previousKeys): array
    {
        for ($i = 0, $count = count($this->nameColumns); $i < $count; $i++) {
            $currentKeys[] = $this->data[$this->index][$i];
        }

        if(self::allKeysAreEmpty($currentKeys) && self::allKeysAreEmpty($previousKeys)) {
            return [];
        }

        $keys = [];
        foreach ($currentKeys as $idx => $key) {

            $key = trim((string) $key);
            if ($key === '' || $key === '0') {
                $keys[] = $previousKeys[$idx];
            } elseif ($key !== '' && $key !== '0') {
                $keys[] = $key;
            } else {
                $keys[] = '';
            }
        }

        return $keys;
    }

    public function getValue($locale)
    {
        return $this->data[$this->index][$this->localeColumns[$locale]];
    }

    public function hasDataToParse(): bool
    {
        return ($this->count() > $this->firstRow);
    }

    public function getLocales()
    {
        return array_keys($this->localeColumns);
    }

    public function getKeyTitles()
    {
        return array_keys($this->nameColumns);
    }

    /**
     * @return list
     */
    public function getKeys(): array
    {
        $keys = [];
        for ($i = 0, $count = count($this->nameColumns); $i < $count; $i++) {
            $keys[] = $this->data[$this->index][$i];
        }
        return $keys;
    }

    public function buildKey($keys): string
    {
        return implode($this->nameSeparator, $keys);
    }

    public static function allKeysAreEmpty($keys): bool
    {
        return !array_filter($keys);
    }

}