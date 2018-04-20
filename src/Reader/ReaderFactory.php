<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Reader;

class ReaderFactory
{
    public function create($resource, $format)
    {
        $format = ucfirst($format);
        $class = sprintf('Atico\SpreadsheetTranslator\Reader\%1$s\%1$sReader', $format);
        return new $class($resource);
    }
}