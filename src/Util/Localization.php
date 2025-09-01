<?php

namespace Atico\SpreadsheetTranslator\Core\Util;

class Localization
{
    public static function getLanguageFromLocale($locale): string
    {
        $parts = explode('_', (string) $locale);
        return $parts[0];
    }
}