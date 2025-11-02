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

namespace Atico\SpreadsheetTranslator\Core\Tests\Unit\Provider;

use Atico\SpreadsheetTranslator\Core\Provider\ProviderFactory;
use Atico\SpreadsheetTranslator\Core\Configuration\Configuration;
use PHPUnit\Framework\TestCase;
use Mockery;

class ProviderFactoryTest extends TestCase
{
    private ProviderFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new ProviderFactory();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetClassNameWithSimpleProviderName(): void
    {
        $reflection = new \ReflectionClass($this->factory);
        $method = $reflection->getMethod('getClassName');
        $method->setAccessible(true);

        $result = $method->invoke($this->factory, 'local_file');

        $this->assertEquals('Atico\SpreadsheetTranslator\Provider\LocalFile\LocalFileProvider', $result);
    }

    public function testGetClassNameWithSingleWordProvider(): void
    {
        $reflection = new \ReflectionClass($this->factory);
        $method = $reflection->getMethod('getClassName');
        $method->setAccessible(true);

        $result = $method->invoke($this->factory, 'google');

        $this->assertEquals('Atico\SpreadsheetTranslator\Provider\Google\GoogleProvider', $result);
    }

    public function testGetClassNameWithUnderscoreSeparator(): void
    {
        $reflection = new \ReflectionClass($this->factory);
        $method = $reflection->getMethod('getClassName');
        $method->setAccessible(true);

        $result = $method->invoke($this->factory, 'google_drive');

        $this->assertEquals('Atico\SpreadsheetTranslator\Provider\GoogleDrive\GoogleDriveProvider', $result);
    }

    public function testGetClassNameFollowsNamingConvention(): void
    {
        $reflection = new \ReflectionClass($this->factory);
        $method = $reflection->getMethod('getClassName');
        $method->setAccessible(true);

        $result = $method->invoke($this->factory, 'custom_provider');

        // Should follow the pattern: Namespace\ProviderName\ProviderNameProvider
        $this->assertStringStartsWith('Atico\SpreadsheetTranslator\Provider\\', $result);
        $this->assertStringEndsWith('Provider', $result);
        $this->assertStringContainsString('CustomProvider', $result);
    }

    /**
     * Note: This test verifies the factory behavior, but actual provider creation
     * would require the provider classes to exist. In a real scenario, you might
     * want to use dependency injection or test with actual provider classes.
     */
    public function testFactoryMethodStructure(): void
    {
        $this->assertTrue(method_exists($this->factory, 'create'));
        $this->assertTrue(method_exists($this->factory, 'getClassName'));
    }
}
