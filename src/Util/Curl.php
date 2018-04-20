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

class Curl
{
    private static function getDefaultCurlParameters($url)
    {
        return array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        );
    }

    private static function buildPostCurSetOptArray($url, $fields)
    {
        $queryFields = http_build_query($fields);
        $postParameters = array(
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $queryFields,
            CURLOPT_HTTPHEADER => array(
                'Content-Length: ' . strlen($queryFields),
            ),
        );
        $defaultParameters = self::getDefaultCurlParameters($url);
        return array_merge($defaultParameters, $postParameters);
    }

    private static function buildGetCurSetOptArray(&$url, $fields)
    {
        $url .= '?' . http_build_query($fields);
        return self::getDefaultCurlParameters($url);
    }

    /**
     * @throws \Exception
     */
    public static function get($url, $fields = array())
    {
        $curl = curl_init();
        curl_setopt_array($curl, self::buildGetCurSetOptArray($url, $fields));

        $result = curl_exec($curl);
        $curlError = self::curlExecHasFailed($result, $curl);
        curl_close($curl);

        if ($curlError) {
            throw new \Exception($curlError);
        }
        return $result;
    }

    /**
     * @throws \Exception
     */
    public function post($url, $fields = array())
    {
        $curl = curl_init();
        curl_setopt_array($curl, $this->buildPostCurSetOptArray($url, $fields));

        $result = curl_exec($curl);
        $curlError = $this->curlExecHasFailed($result, $curl);
        curl_close($curl);

        if ($curlError) {
            throw new \Exception($curlError);
        }
        return $result;
    }

    protected static function curlExecHasFailed($result, $curl)
    {
        $curlError = '';
        if (false === $result) {
            if (curl_errno($curl)) {
                $curlError = 'curl_setopt_array() failed: ' . curl_error($curl);
                return $curlError;
            } else {
                $curlError = 'curl_setopt_array(): empty response';
                return $curlError;
            }
        }
        return $curlError;
    }
}