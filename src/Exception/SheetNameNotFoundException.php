<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Exception;

class SheetNameNotFoundException extends \Exception
{
    const ERROR_MESSAGE = 'Sheet name "%s" not found. ¿Did you set a properly value for "sheet-name" parameter?';

    public static function create($name)
    {
        return new self(sprintf(self::ERROR_MESSAGE, $name));
    }
}