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

namespace Atico\SpreadsheetTranslator\Core\Tests\Integration;

use Atico\SpreadsheetTranslator\Core\SpreadsheetTranslator;
use PHPUnit\Framework\TestCase;

/**
 * Integration tests for SpreadsheetTranslator
 *
 * Note: These tests verify the core structure and behavior.
 * Full integration tests would require provider and exporter implementations.
 */
class SpreadsheetTranslatorTest extends TestCase
{
    private array $sampleConfiguration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sampleConfiguration = [
            'book1' => [
                'shared' => [
                    'row_header' => 0,
                    'first_row' => 0,
                    'name_separator' => '.',
                ],
                'provider' => [
                    'name' => 'local_file',
                    'path' => '/path/to/spreadsheet.xlsx',
                ],
                'parser' => [],
                'exporter' => [
                    'format' => 'yml',
                    'path' => sys_get_temp_dir() . '/translations',
                ],
            ],
        ];
    }

    public function testConstructorInitializesWithConfiguration(): void
    {
        $translator = new SpreadsheetTranslator($this->sampleConfiguration);

        $this->assertInstanceOf(SpreadsheetTranslator::class, $translator);
    }

    public function testSetConfigurationUpdatesConfiguration(): void
    {
        $translator = new SpreadsheetTranslator($this->sampleConfiguration);

        // Get initial configuration
        $initialConfig = $translator->getConfiguration();
        $this->assertArrayHasKey('book1', $initialConfig);

        // Create new configuration and prepare it manually
        $newConfig = [
            'book2' => [
                'shared' => [
                    'row_header' => 1,
                    'first_row' => 1,
                    'name_separator' => '_',
                    'temp_local_source_file' => tempnam(sys_get_temp_dir(), 'test_'),
                ],
                'provider' => [
                    'name' => 'local_file',
                    'path' => '/new/path.xlsx',
                ],
                'parser' => [],
                'exporter' => [
                    'format' => 'php',
                    'path' => sys_get_temp_dir() . '/new',
                ],
            ],
        ];

        // Manually prepare the configuration to avoid issues
        foreach ($newConfig as $domain => $groups) {
            $sharedOptions = $groups['shared'] ?? [];
            $sharedOptions['domain'] = $domain;
            foreach ($groups as $section => $group) {
                $newConfig[$domain][$section] = array_merge($sharedOptions, $group);
            }
            $newConfig[$domain]['parser'] = $sharedOptions;
        }

        $translator->setConfiguration($newConfig);
        $config = $translator->getConfiguration();

        $this->assertArrayHasKey('book2', $config);
        $this->assertArrayHasKey('provider', $config['book2']);

        // Clean up temp file
        if (isset($newConfig['book2']['shared']['temp_local_source_file'])) {
            @unlink($newConfig['book2']['shared']['temp_local_source_file']);
        }
    }

    public function testGetConfigurationReturnsConfiguration(): void
    {
        $translator = new SpreadsheetTranslator($this->sampleConfiguration);

        $config = $translator->getConfiguration();

        $this->assertIsArray($config);
        $this->assertArrayHasKey('book1', $config);
        $this->assertArrayHasKey('provider', $config['book1']);
        $this->assertArrayHasKey('parser', $config['book1']);
        $this->assertArrayHasKey('exporter', $config['book1']);
    }

    public function testConfigurationHasRequiredProviderKeys(): void
    {
        $translator = new SpreadsheetTranslator($this->sampleConfiguration);
        $config = $translator->getConfiguration();

        $this->assertArrayHasKey('name', $config['book1']['provider']);
        $this->assertArrayHasKey('path', $config['book1']['provider']);
    }

    public function testConfigurationHasRequiredParserKeys(): void
    {
        $translator = new SpreadsheetTranslator($this->sampleConfiguration);
        $config = $translator->getConfiguration();

        // After ConfigurationPreparer, parser inherits from shared
        $this->assertArrayHasKey('row_header', $config['book1']['parser']);
        $this->assertArrayHasKey('first_row', $config['book1']['parser']);
        $this->assertArrayHasKey('name_separator', $config['book1']['parser']);
        $this->assertArrayHasKey('domain', $config['book1']['parser']);
    }

    public function testConfigurationHasRequiredExporterKeys(): void
    {
        $translator = new SpreadsheetTranslator($this->sampleConfiguration);
        $config = $translator->getConfiguration();

        $this->assertArrayHasKey('format', $config['book1']['exporter']);
        $this->assertArrayHasKey('path', $config['book1']['exporter']);
    }

    public function testConstructorWithEmptyConfiguration(): void
    {
        $translator = new SpreadsheetTranslator([]);

        $this->assertInstanceOf(SpreadsheetTranslator::class, $translator);
        $this->assertIsArray($translator->getConfiguration());
    }

    public function testMultipleBooksConfiguration(): void
    {
        $multiBookConfig = [
            'book1' => $this->sampleConfiguration['book1'],
            'book2' => [
                'shared' => [
                    'row_header' => 1,
                    'first_row' => 1,
                    'name_separator' => '_',
                ],
                'provider' => [
                    'name' => 'google_drive',
                    'path' => 'https://docs.google.com/spreadsheets/...',
                ],
                'parser' => [],
                'exporter' => [
                    'format' => 'php',
                    'path' => sys_get_temp_dir() . '/translations2',
                ],
            ],
        ];

        $translator = new SpreadsheetTranslator($multiBookConfig);
        $config = $translator->getConfiguration();

        $this->assertCount(2, $config);
        $this->assertArrayHasKey('book1', $config);
        $this->assertArrayHasKey('book2', $config);
    }

    public function testConfigurationWithDifferentNameSeparators(): void
    {
        $config = $this->sampleConfiguration;
        $config['book1']['shared']['name_separator'] = '_';

        $translator = new SpreadsheetTranslator($config);
        $result = $translator->getConfiguration();

        $this->assertEquals('_', $result['book1']['parser']['name_separator']);
    }

    public function testConfigurationWithDifferentRowHeaders(): void
    {
        $config = $this->sampleConfiguration;
        $config['book1']['shared']['row_header'] = 2;
        $config['book1']['shared']['first_row'] = 3;

        $translator = new SpreadsheetTranslator($config);
        $result = $translator->getConfiguration();

        $this->assertEquals(2, $result['book1']['parser']['row_header']);
        $this->assertEquals(3, $result['book1']['parser']['first_row']);
    }

    public function testPublicMethodsExist(): void
    {
        $translator = new SpreadsheetTranslator($this->sampleConfiguration);

        $this->assertTrue(method_exists($translator, 'setConfiguration'));
        $this->assertTrue(method_exists($translator, 'getConfiguration'));
        $this->assertTrue(method_exists($translator, 'processSheet'));
        $this->assertTrue(method_exists($translator, 'processBook'));
        $this->assertTrue(method_exists($translator, 'processAllBooks'));
    }

    /**
     * Test that verifies the structure is ready for processing
     * Note: Actual processing would require provider/exporter implementations
     */
    public function testProcessingMethodsAreCallable(): void
    {
        $translator = new SpreadsheetTranslator($this->sampleConfiguration);

        $this->assertIsCallable([$translator, 'processSheet']);
        $this->assertIsCallable([$translator, 'processBook']);
        $this->assertIsCallable([$translator, 'processAllBooks']);
    }
}
