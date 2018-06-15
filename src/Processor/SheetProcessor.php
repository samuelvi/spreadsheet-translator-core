<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Processor;

use Atico\SpreadsheetTranslator\Core\Resource\ResourceInterface;

class SheetProcessor extends ProcessorBase
{
    public function processSheet($sheetName)
    {
        /** @var ResourceInterface $resource */
        $resource = $this->readSourceResource();

        parent::parseSheetAndSaveIntoTranslatedFile($sheetName, $resource);
    }
}