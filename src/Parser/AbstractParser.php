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
namespace Atico\SpreadsheetTranslator\Core\Parser;

use Atico\SpreadsheetTranslator\Core\Configuration\ConfigurationInterface;

abstract class AbstractParser
{
    /** @var  ConfigurationInterface $configuration */
    protected $configuration;

    protected $rowHeader;
    protected $firstRow;
    protected $nameSeparator;

    protected $nameColumns = [];
    protected $localeColumns = [];

    protected $data = [];
    protected $index;

    protected $header;
}
