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

class BookProcessor extends ProcessorBase
{
    public function processBook()
    {
        /** @var ResourceInterface $resource */
        $resource = $this->readSourceResource();

        $sheetNames = $this->getSheetNames($resource);

        $this->parseAllSheetsAndSaveIntoCorrespondingTranslatedFiles($sheetNames, $resource);
    }

    private function getSheetNames(ResourceInterface $resource)
    {

        /** @var ReaderInterface $reader */
        $readerFactory = new ReaderFactory();
        $reader = $readerFactory->create($resource->getValue(), $resource->getFormat());
        return $reader->getSheetNames();
    }

    private function parseAllSheetsAndSaveIntoCorrespondingTranslatedFiles($sheetNames, ResourceInterface $resource)
    {
        foreach ($sheetNames as $sheetName) {
            parent::parseSheetAndSaveIntoTranslatedFile($sheetName, $resource);
        }
    }
}