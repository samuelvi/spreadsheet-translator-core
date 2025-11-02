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

namespace Atico\SpreadsheetTranslator\Core\Tests\Unit\Configuration;

use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    private array $sampleConfiguration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sampleConfiguration = [
            'book1' => [
                'provider' => [
                    'name' => 'local_file',
                    'path' => '/path/to/file.xlsx',
                ],
                'exporter' => [
                    'format' => 'yml',
                    'path' => '/output/path',
                ],
                'parser' => [
                    'row_header' => 0,
                    'first_row' => 0,
                    'name_separator' => '.',
                ],
            ],
        ];
    }

    public function testConstructorInitializesConfiguration(): void
    {
        $config = new Configuration($this->sampleConfiguration, 'provider');

        $this->assertInstanceOf(Configuration::class, $config);
    }

    public function testGetOptionReturnsExistingValue(): void
    {
        $config = new Configuration($this->sampleConfiguration, 'provider');

        $name = $config->getOption('name');

        $this->assertEquals('local_file', $name);
    }

    public function testGetOptionReturnsNullForNonExistingOption(): void
    {
        $config = new Configuration($this->sampleConfiguration, 'provider');

        $nonExisting = $config->getOption('non_existing_key');

        $this->assertNull($nonExisting);
    }

    public function testGetOptionsReturnsAllOptions(): void
    {
        $config = new Configuration($this->sampleConfiguration, 'provider');

        $options = $config->getOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('name', $options);
        $this->assertArrayHasKey('path', $options);
    }

    public function testMagicGetMethodWithCamelCase(): void
    {
        $config = new Configuration($this->sampleConfiguration, 'parser');

        $rowHeader = $config->getRowHeader();

        $this->assertEquals(0, $rowHeader);
    }

    public function testMagicGetMethodWithUnderscoreProperty(): void
    {
        $config = new Configuration($this->sampleConfiguration, 'parser');

        $firstRow = $config->getFirstRow();

        $this->assertEquals(0, $firstRow);
    }

    public function testMagicGetMethodWithSeparator(): void
    {
        $config = new Configuration($this->sampleConfiguration, 'parser');

        $nameSeparator = $config->getNameSeparator();

        $this->assertEquals('.', $nameSeparator);
    }

    public function testMagicGetMethodReturnsNullForNonExisting(): void
    {
        $config = new Configuration($this->sampleConfiguration, 'provider');

        $result = $config->getNonExistingProperty();

        $this->assertNull($result);
    }

    public function testConfigurationWithExporterGroup(): void
    {
        $config = new Configuration($this->sampleConfiguration, 'exporter');

        $format = $config->getFormat();
        $path = $config->getPath();

        $this->assertEquals('yml', $format);
        $this->assertEquals('/output/path', $path);
    }

    public function testNonGetMethodReturnsNull(): void
    {
        $config = new Configuration($this->sampleConfiguration, 'provider');

        // Calling a method that doesn't start with 'get'
        $result = $config->__call('setName', ['value']);

        $this->assertNull($result);
    }

    public function testConfigurationWithDifferentDataTypes(): void
    {
        $testConfig = [
            'book1' => [
                'test' => [
                    'string_value' => 'test',
                    'int_value' => 123,
                    'bool_value' => true,
                    'array_value' => ['a', 'b', 'c'],
                ],
            ],
        ];

        $config = new Configuration($testConfig, 'test');

        $this->assertEquals('test', $config->getStringValue());
        $this->assertEquals(123, $config->getIntValue());
        $this->assertTrue($config->getBoolValue());
        $this->assertIsArray($config->getArrayValue());
        $this->assertCount(3, $config->getArrayValue());
    }
}
