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

class DataParser extends AbstractParser implements \Iterator
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

    public function current()
    {
        return $this;
    }

    public function next()
    {
        $this->index++;
        return $this;
    }

    public function key()
    {
        return $this->data[$this->index];
    }

    public function valid()
    {
        return (count($this->data) > ($this->index));
    }

    public function rewind()
    {
        $this->index = $this->firstRow + 1;
    }

    public function count()
    {
        return count($this->data);
    }


    private static function isValidLocale($locale)
    {
        return preg_match('/^([a-z]{2})((-|_)[A-Z]{2})?$/', $locale);
    }

    protected function configureKeyColumns()
    {
        for ($i = 0, $count = count($this->header); $i < $count; $i++) {
            $key = $this->header[$i];
            if (!self::isValidLocale($key)) {
                $this->nameColumns[$key] = $i;
            }
        }
    }

    protected function configureLocaleColumns()
    {
        for ($i = 0, $count = count($this->header); $i < $count; $i++) {
            $locale = $this->header[$i];
            if (self::isValidLocale($locale)) {
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

    public function getValue($locale)
    {
        return $this->data[$this->index][$this->localeColumns[$locale]];
    }

    public function hasDataToParse()
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

    public function getKeys()
    {
        $keys = [];
        for ($i = 0, $count = count($this->nameColumns); $i < $count; $i++) {
            $keys[] = $this->data[$this->index][$i];
        }
        return $keys;
    }

    public function buildKey($keys)
    {
        return join($keys, $this->nameSeparator);
    }
}