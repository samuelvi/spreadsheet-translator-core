<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Exporter;

class ExportContent implements ExportContentInterface
{
    private $destinationFile;
    private $translations;
    private $locale;

    function __construct($destinationFile, $translations, $locale)
    {
        $this->destinationFile = $destinationFile;
        $this->translations = $translations;
        $this->locale = $locale;
    }

    public function getDestinationFile()
    {
        return $this->destinationFile;
    }

    public function setDestinationFile($destinationFile)
    {
        $this->destinationFile = $destinationFile;
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function setTranslations($translations)
    {
        $this->translations = $translations;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}