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

use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;

class ExporterFactory
{
    public function create(Configuration $configuration)
    {
        $exportFormat = $configuration->getFormat();
        $class = sprintf('Atico\SpreadsheetTranslator\Exporter\%1$s\%1$s', ucfirst($exportFormat));
        return new $class($configuration);
    }
}