<?php

namespace Atico\SpreadsheetTranslator\Core\Util;

class Localization
{
    public static function getLanguageFromLocale($locale)
    {
        $parts = explode('_', $locale);
        return $parts[0];
    }
}