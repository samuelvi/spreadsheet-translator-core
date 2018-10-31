<?php

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
            return [];
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