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

interface ReaderInterface
{
    public function getSheets();
    public function getSheetNames();
    public function getDataBySheetName($name);
    public function getData($sheet);
    public function getTitle($index);
}