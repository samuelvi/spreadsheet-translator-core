<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Parser\Resolver;

class LazyKeyResolver
{
    private $nameSeparator;

    public function __construct($nameSeparator)
    {
        $this->nameSeparator = $nameSeparator;
    }

    public function resolveLazyKeys($currentKeys, $previousKeys)
    {
        if ($this->allKeysAreEmpty($currentKeys)) {
            return $previousKeys;
        }

        $keys = [];
        foreach ($currentKeys as $idx => $key) {

            if (empty($key)) {
                $keys[] = $previousKeys[$idx];
            } else if (!empty($key)) {
                $keys[] = $key;
            }
        }

        return $keys;
    }

    public function allKeysAreEmpty($keys)
    {
        foreach ($keys as $key) {
            if (!empty($key)) return false;
        }
        return true;
    }
}