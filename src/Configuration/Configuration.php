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

use Atico\SpreadsheetTranslator\Core\Util\Strings;

class Configuration implements ConfigurationInterface
{
    /** @var  array $options */
    protected $options;

    protected $nonRequiredOptions = array('parser');

    /**
     * @throws \Exception
     */
    public function __construct($configuration, $groupName)
    {
        $this->parseConfiguration($configuration, $groupName);
    }

    /**
     * @throws \Exception
     */
    private function parseConfiguration($configuration, $groupName)
    {
        $groups = array_values($configuration)[0];

        //$groupedOptions = $options[$keys[0]];
        $sharedOptions = (isset($groups['shared'])) ? $groups['shared'] : array();
        $sharedOptions['domain'] = key($configuration);

        if (!isset($groups[$groupName])) {

            if (in_array($groupName, $this->nonRequiredOptions)) {

                return $sharedOptions;
            } else {
                throw new \Exception(sprintf('Configuration Group for "%s" not found', $groupName));
            }
        }

        $this->options = array_merge($sharedOptions, $groups[$groupName]);
    }

    public function __call($method, $args)
    {
        if (substr($method, 0, 3) == 'get') {
            return $this->_get($method, $args);
        }
    }

    private function _get($method, $args)
    {
        $name = $this->parseOptionFromMethodCall($method);
        return $this->getOption($name);
    }

    private function parseOptionFromMethodCall($method)
    {
        return Strings::uncamelize(str_replace('get', '', $method));
    }

    public function getOption($name)
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        } else {
            return null;
        }
    }
}