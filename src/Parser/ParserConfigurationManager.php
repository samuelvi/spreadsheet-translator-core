<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Parser;

use Atico\SpreadsheetTranslator\Core\Configuration\AbstractConfigurationManager;

class ParserConfigurationManager extends AbstractConfigurationManager implements ParserConfigurationInterface
{
    public function getRowHeader()
    {
        return $this->getNonRequiredOption('row_header', 0);
    }

    public function getFirstRow()
    {
        return $this->getNonRequiredOption('first_row', 0);
    }

    public function getNameSeparator()
    {
        return $this->getNonRequiredOption('name_separator', '.');
    }

    public function getLazyMode()
    {
        return $this->getNonRequiredOption('lazy_mode', false);
    }
}