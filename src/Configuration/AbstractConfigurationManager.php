<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Configuration;

abstract class AbstractConfigurationManager
{
    /** @var Configuration $configuration */
    protected $configuration;

    function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getDefaultFormat()
    {
        return 'xlsx';
    }

    protected function getNonRequiredOption($name, $defaultValue)
    {
        $value = $this->configuration->getOption($name);

        if (null === $value) {
            $value = $defaultValue;
        }
        return $value;
    }

    /**
     * @throws \Exception
     */
    protected function getRequiredOption($name)
    {
        $value = $this->configuration->getOption($name);
        if (null === $value) {
            throw new \Exception(sprintf('The configuration parameter: "%s" is required', $name));
        }
        return $value;
    }
}