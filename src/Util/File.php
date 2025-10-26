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

class File
{
    public static function generateTempFile($prefix = null, $extension = null)
    {
        $tempFileName = sys_get_temp_dir();
        if (!empty($extension)) {
            $tempFileName = sprintf('%s.%s', $tempFileName, $extension);
        }
        return tempnam($tempFileName, $prefix);
    }
}
