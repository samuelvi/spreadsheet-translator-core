<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AticO\SpreadsheetTranslator\Core\Provider;

use AticO\SpreadsheetTranslator\Core\Configuration\Configuration;
use AticO\SpreadsheetTranslator\Core\Util\Strings;

class ProviderFactory
{
    protected function getClassName($providerName)
    {
        $providerNameCamelized = Strings::camelize($providerName);
        $class = sprintf('AticO\SpreadsheetTranslator\Provider\%1$s\%1$sProvider', $providerNameCamelized);
        return $class;
    }

    public function create(Configuration $configuration)
    {
        $providerName = $configuration->getName();
        $class = $this->getClassName($providerName);
        return new $class($configuration);
    }
}