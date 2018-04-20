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
    
    public function processSheet($sheetName)
    {
        $sheetProcessor = new SheetProcessor($this->configuration);
        $sheetProcessor->processSheet($sheetName);
    }

    public function processBook()
    {
        $sheetProcessor = new BookProcessor($this->configuration);
        $sheetProcessor->processBook();
    }

}