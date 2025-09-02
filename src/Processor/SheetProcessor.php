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

use Exception;

class SheetProcessor extends ProcessorBase implements SheetProcessorInterface
{
    /**
     * @throws Exception
     */
    public function processSheet($sheetName): void
    {
        parent::parseSheetAndSaveIntoTranslatedFile($sheetName);
    }
}