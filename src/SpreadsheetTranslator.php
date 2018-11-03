<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core;

use Atico\SpreadsheetTranslator\Core\Processor\BookProcessor;
use Atico\SpreadsheetTranslator\Core\Processor\SheetProcessor;

class SpreadsheetTranslator
{
    /** @var  array $configuration */
    protected $configuration;

    function __construct($configuration = array())
    {
        $this->setConfiguration($configuration);
    }

    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function processSheet($sheetName, $bookName)
    {
        $sheetProcessor = SheetProcessor::createFromConfiguration([$bookName => $this->configuration[$bookName]]);
        $sheetProcessor->processSheet($sheetName);
    }

    /**
     * @throws \Exception
     */
    public function processAllBooks()
    {
        foreach ($this->configuration as $bookName => $configurationGroup) {

            /** @var BookProcessor $bookProcessor */
            $bookProcessor = BookProcessor::createFromConfiguration([$bookName => $configurationGroup]);
            $bookProcessor->processBook();
        }
    }

    public function processBook($bookName)
    {
        $bookProcessor = BookProcessor::createFromConfiguration([$bookName => $this->configuration[$bookName]]);
        $bookProcessor->processBook();
    }
}