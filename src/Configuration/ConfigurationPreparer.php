<?php

namespace Atico\SpreadsheetTranslator\Core\Configuration;

class ConfigurationPreparer
{
    protected $nonRequiredOptions = array('parser');

    public static function prepareConfiguration(&$configuration)
    {
        foreach ($configuration as $domain => $groups) {

            $sharedOptions = (isset($groups['shared'])) ? $groups['shared'] : [];
            $sharedOptions['domain'] = $domain;

            if (!key_exists('temp_local_source_file', $sharedOptions)) {
                $sharedOptions['temp_local_source_file'] = tempnam(sys_get_temp_dir(), 'spreadsheet_translator_');
            }

            foreach ($groups as $section => $group) {

                $configuration[$domain][$section] = array_merge($sharedOptions, $group);
            }

            $configuration[$domain]['parser'] = $sharedOptions;
        }
    }

    public static function cleanUp($configuration)
    {
        foreach ($configuration as $domain => $groups) {
            @unlink($groups['shared']['temp_local_source_file']);
        }
    }
}