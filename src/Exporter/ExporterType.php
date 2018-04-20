<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AticO\SpreadsheetTranslator\Core\Exporter;

interface ExporterType
{
    const xliff = 'xliff';
    const php = 'php';
    const yml = 'yml';
}