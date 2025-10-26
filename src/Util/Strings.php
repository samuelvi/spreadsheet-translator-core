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
namespace Atico\SpreadsheetTranslator\Core\Util;

class Strings
{
    public static function camelize($string, $separator = '_'): string
    {
        return implode('', array_map(ucfirst(...), explode($separator, (string) $string)));
    }

    public static function uncamelize($string, string $separator = "_"): string
    {
        return strtolower((string) preg_replace('/(?<!^)[A-Z]/', sprintf('%s$0', $separator), (string) $string));
    }
}
