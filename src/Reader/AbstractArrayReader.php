<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AticO\SpreadsheetTranslator\Core\Reader;

abstract class AbstractArrayReader implements \Iterator
{
    /** @var  integer $index */
    protected $index;

    abstract public function getTitle($index);
    abstract public function getSheets();

    public function current()
    {
        return $this->getSheets()[$this->index];
    }

    public function next()
    {
        $this->index++;
    }

    public function key()
    {
        return $this->getTitle($this->index);
    }

    public function valid()
    {
        return (count($this->getSheets()) > ($this->index));
    }

    public function rewind()
    {
        $this->index = 0;
    }

    public function count()
    {
        return count($this->getSheets());
    }
}