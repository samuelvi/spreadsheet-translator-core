<?php

namespace Atico\SpreadsheetTranslator\Core\Configuration;

class ConfigurationPreparer
{
    protected $nonRequiredOptions = ['parser'];

    public static function prepareConfiguration(array &$configuration): void
    {
        foreach ($configuration as $domain => $groups) {

            $sharedOptions = $groups['shared'] ?? [];
            $sharedOptions['domain'] = $domain;

            if (!array_key_exists('temp_local_source_file', $sharedOptions)) {
                $sharedOptions['temp_local_source_file'] = tempnam(sys_get_temp_dir(), 'spreadsheet_translator_');
            }

            foreach ($groups as $section => $group) {

                $configuration[$domain][$section] = array_merge($sharedOptions, $group);
            }

            $configuration[$domain]['parser'] = $sharedOptions;
        }
    }

    public static function cleanUp($configuration): void
    {
        foreach ($configuration as $groups) {
            @unlink($groups['shared']['temp_local_source_file']);
        }
    }
}