<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Provider;

use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;
use Atico\SpreadsheetTranslator\Core\Util\Strings;

class ProviderFactory
{
    protected function getClassName($providerName): string
    {
        $providerNameCamelized = Strings::camelize($providerName);
        return sprintf('Atico\SpreadsheetTranslator\Provider\%1$s\%1$sProvider', $providerNameCamelized);
    }

    public function create(Configuration $configuration)
    {
        $providerName = $configuration->getName();
        $class = $this->getClassName($providerName);
        return new $class($configuration);
    }
}