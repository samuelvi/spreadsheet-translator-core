<?php

/*
 * This file is part of the Atico/SpreadsheetTranslator package.
 *
 * (c) Samuel Vicent <samuelvicent@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Atico\SpreadsheetTranslator\Core\Util;

use Exception;

class BrowserPathManager
{
    const BROWSER_GOOGLE_CHROME = 'google_chrome';
    const BROWSER_FIREFOX = 'firefox';
    const BROWSER_SAFARI = 'safari';

    const OS_WIN = 'win';
    const OS_MAC = 'mac';
    const OS_LINUX = 'linux';

    /**
     * @throws Exception
     */
    private function getOS(): string
    {
        if (stripos(PHP_OS, 'win') === 0) {
            return self::OS_WIN;
        } elseif (stripos(PHP_OS, 'darwin') === 0) {
            return self::OS_MAC;
        } elseif (stripos(PHP_OS, 'linux') === 0) {
            return self::OS_LINUX;
        }
        throw new Exception(sprintf('Unsupported Operating System. PHP_OS: %s', PHP_OS));
    }

    /**
     * @throws Exception
     */
    public function getBrowserCommandForOpeningUrl($browser, $url): string
    {
        $os = $this->getOS();
        $paths = [
            'mac' => [
                'browsers' => [
                    'firefox' => 'Firefox',
                    'google_chrome' => 'Google\ Chrome',
                    'safari' => 'Safari',
                ],
                'command' => 'open -a %s "%s"',
            ],
        ];

        return sprintf($paths[$os]['command'], $paths[$os]['browsers'][$browser], $url);
    }
}
