<?php

declare(strict_types=1);

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
    function __construct(private $destinationFile, private $translations, private $locale)
    {
    }

    public function getDestinationFile()
    {
        return $this->destinationFile;
    }

    public function setDestinationFile($destinationFile): void
    {
        $this->destinationFile = $destinationFile;
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function setTranslations($translations): void
    {
        $this->translations = $translations;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }
}
