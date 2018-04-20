<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AticO\SpreadsheetTranslator\Core\Configuration;

use AticO\SpreadsheetTranslator\Core\Util\Strings;

class Configuration implements ConfigurationInterface
{
    /** @var  array $options */
    protected $options;

    protected $nonRequiredOptions = array('parser');

    /**
     * @throws \Exception
     */
    public function __construct(array $options, $key)
    {
        $this->checkNumberOfOptionsMustBeOne($options);

        $keys = array_keys($options);
        $groupedOptions = $options[$keys[0]];
        $sharedOptions = (isset($groupedOptions['shared']))?$groupedOptions['shared']:array();

        if (!isset($groupedOptions[$key])) {

            if (in_array($key, $this->nonRequiredOptions)) {
                return $sharedOptions;
            } else {
                throw new \Exception(sprintf('Configuration for "%s" not found', $key));
            }
        }

        $this->options = array_merge($sharedOptions, $groupedOptions[$key]);
    }

    /**
     * @throws \Exception
     */
    private function checkNumberOfOptionsMustBeOne($options)
    {
        $keys = array_keys($options);

        if (count($keys) != 1) {
            throw new \Exception(sprintf('Only one key configuration is required. Found: %s.', count($keys)));
        }
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