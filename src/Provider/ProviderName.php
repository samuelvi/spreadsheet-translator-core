<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AticO\SpreadsheetTranslator\Core\Exporter;

interface ProviderName
{
    const GOOGLE_DRIVE = 'google_drive';
    const GOOGLE_DRIVE_AUTH = 'google_drive_auth';
    const ONE_DRIVE = 'one_drive';
    const ONE_DRIVE_AUTH = 'onedrive_auth';
    const LOCAL_FILE = 'local_file';
}