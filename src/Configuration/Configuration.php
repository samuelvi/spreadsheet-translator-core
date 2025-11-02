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
namespace Atico\SpreadsheetTranslator\Core\Configuration;

use Exception;
use Atico\SpreadsheetTranslator\Core\Util\Strings;

class Configuration implements ConfigurationInterface
{
    /** @var  array $options */
    protected $options;

//    protected $nonRequiredOptions = array('parser');
    /**
     * @throws Exception
     */
    public function __construct($configuration, $groupName)
    {
        $groups = array_values($configuration)[0];
        $this->options = $groups[$groupName];
    }

    public function __call(string $method, array $args)
    {
        if (str_starts_with($method, 'get')) {
            return $this->_get($method);
        }
        return null;
    }

    private function _get(string $method)
    {
        $name = $this->parseOptionFromMethodCall($method);
        return $this->getOption($name);
    }

    private function parseOptionFromMethodCall(string $method): string
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

    public function getOptions()
    {
        return $this->options;
    }
}
