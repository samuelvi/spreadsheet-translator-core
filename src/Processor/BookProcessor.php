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

use Atico\SpreadsheetTranslator\Core\Reader\ReaderFactory;
use Atico\SpreadsheetTranslator\Core\Reader\ReaderInterface;
use Atico\SpreadsheetTranslator\Core\Resource\ResourceInterface;

class BookProcessor extends ProcessorBase implements BookProcessorInterface
{
    public function processBook()
    {
        $sheetNames = $this->getSheetNames();

        $this->parseAllSheetsAndSaveIntoCorrespondingTranslatedFiles($sheetNames);
    }

    private function getSheetNames()
    {
        /** @var ResourceInterface $resource */
        $resource = $this->getResource();

        /** @var ReaderInterface $reader */
        $readerFactory = new ReaderFactory();
        $reader = $readerFactory->create($resource->getValue(), $resource->getFormat());
        return $reader->getSheetNames();
    }

    private function parseAllSheetsAndSaveIntoCorrespondingTranslatedFiles($sheetNames)
    {
        foreach ($sheetNames as $sheetName) {
            parent::parseSheetAndSaveIntoTranslatedFile($sheetName);
        }
    }
}