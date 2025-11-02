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

namespace Atico\SpreadsheetTranslator\Core\Tests\Unit\Parser;

use Atico\SpreadsheetTranslator\Core\Parser\DataParser;
use PHPUnit\Framework\TestCase;

class DataParserTest extends TestCase
{
    private array $sampleData;
    private int $rowHeader = 0;
    private int $firstRow = 0;
    private string $nameSeparator = '.';

    protected function setUp(): void
    {
        parent::setUp();

        // Sample data with header and two locales
        $this->sampleData = [
            ['key1', 'key2', 'es', 'en'], // Header row
            ['user', 'name', 'Nombre', 'Name'],
            ['user', 'email', 'Correo', 'Email'],
            ['button', 'submit', 'Enviar', 'Submit'],
        ];
    }

    public function testConstructorInitializesParser(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $this->assertInstanceOf(DataParser::class, $parser);
        $this->assertEquals($this->sampleData, $parser->getData());
    }

    public function testGetLocalesReturnsValidLocales(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $locales = $parser->getLocales();

        $this->assertIsArray($locales);
        $this->assertCount(2, $locales);
        $this->assertContains('es', $locales);
        $this->assertContains('en', $locales);
    }

    public function testGetLocalesWithRegionalLocales(): void
    {
        $dataWithRegionalLocales = [
            ['key', 'es_ES', 'en_US', 'en-GB'],
            ['greeting', 'Hola', 'Hello', 'Hello'],
        ];

        $parser = new DataParser($dataWithRegionalLocales, 0, 0, '.');
        $locales = $parser->getLocales();

        $this->assertContains('es_ES', $locales);
        $this->assertContains('en_US', $locales);
        $this->assertContains('en-GB', $locales);
    }

    public function testGetKeyTitlesReturnsColumnNames(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $keyTitles = $parser->getKeyTitles();

        $this->assertIsArray($keyTitles);
        $this->assertCount(2, $keyTitles);
        $this->assertContains('key1', $keyTitles);
        $this->assertContains('key2', $keyTitles);
    }

    public function testResolveKeyBuildsCorrectKey(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        // Rewind to first data row
        $parser->rewind();

        $key = $parser->resolveKey();

        $this->assertEquals('user.name', $key);
    }

    public function testResolveKeyWithDifferentSeparator(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, '_');

        $parser->rewind();

        $key = $parser->resolveKey();

        $this->assertEquals('user_name', $key);
    }

    public function testGetValueReturnsCorrectTranslation(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $parser->rewind();

        $valueEs = $parser->getValue('es');
        $valueEn = $parser->getValue('en');

        $this->assertEquals('Nombre', $valueEs);
        $this->assertEquals('Name', $valueEn);
    }

    public function testIteratorFunctionality(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $count = 0;
        foreach ($parser as $index => $row) {
            $count++;
            $this->assertInstanceOf(DataParser::class, $row);
        }

        // Should iterate over 3 data rows (excluding header)
        $this->assertEquals(3, $count);
    }

    public function testValidReturnsTrueWhenHasData(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $parser->rewind();

        $this->assertTrue($parser->valid());
    }

    public function testValidReturnsFalseAfterLastRow(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        // Move through all rows
        foreach ($parser as $row) {
            // iterate
        }

        $this->assertFalse($parser->valid());
    }

    public function testCountReturnsCorrectNumberOfRows(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $this->assertEquals(4, $parser->count());
    }

    public function testHasDataToParseReturnsTrueWithData(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $this->assertTrue($parser->hasDataToParse());
    }

    public function testHasDataToParseReturnsFalseWithOnlyHeader(): void
    {
        $dataOnlyHeader = [
            ['key1', 'key2', 'es', 'en'],
        ];

        // When first_row is 0 and there's only 1 row (the header), count() returns 1
        // hasDataToParse checks if count() > firstRow, which is 1 > 0 = true
        // So we need firstRow to equal count() for this to be false
        $parser = new DataParser($dataOnlyHeader, 0, 1, '.');

        $this->assertFalse($parser->hasDataToParse());
    }

    public function testBuildKeyWithMultipleKeys(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $keys = ['user', 'profile', 'name'];
        $result = $parser->buildKey($keys);

        $this->assertEquals('user.profile.name', $result);
    }

    public function testAllKeysAreEmptyReturnsTrueForEmptyArray(): void
    {
        $this->assertTrue(DataParser::allKeysAreEmpty([]));
        $this->assertTrue(DataParser::allKeysAreEmpty(['', '', '']));
        $this->assertTrue(DataParser::allKeysAreEmpty([null, null]));
    }

    public function testAllKeysAreEmptyReturnsFalseWhenHasValues(): void
    {
        $this->assertFalse(DataParser::allKeysAreEmpty(['key', '', '']));
        $this->assertFalse(DataParser::allKeysAreEmpty(['user']));
    }

    public function testResolveLazyKeysReturnsEmptyWhenAllEmpty(): void
    {
        // Create data with empty keys
        $dataWithEmptyKeys = [
            ['key1', 'key2', 'es'],
            ['', '', 'Empty'],
        ];

        $parser = new DataParser($dataWithEmptyKeys, 0, 0, '.');
        $parser->rewind(); // Move to first data row which has empty keys

        $result = $parser->resolveLazyKeys(['', '']);

        $this->assertEmpty($result);
    }

    public function testResolveLazyKeysUsePreviousWhenCurrentEmpty(): void
    {
        $dataWithEmptyKeys = [
            ['key1', 'key2', 'es'],
            ['user', 'name', 'Nombre'],
            ['', 'email', 'Correo'], // Empty first key should use previous
        ];

        $parser = new DataParser($dataWithEmptyKeys, 0, 0, '.');
        $parser->rewind();
        $parser->next(); // Move to second row

        $result = $parser->resolveLazyKeys(['user', 'name']);

        $this->assertEquals('user', $result[0]);
        $this->assertEquals('email', $result[1]);
    }

    public function testGetKeysReturnsCurrentRowKeys(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $parser->rewind();

        $keys = $parser->getKeys();

        $this->assertIsArray($keys);
        $this->assertEquals(['user', 'name'], $keys);
    }

    public function testRewindResetsIteratorToFirstDataRow(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        // Iterate to end
        foreach ($parser as $row) {
            // iterate
        }

        // Rewind and check we're back at the start
        $parser->rewind();
        $this->assertTrue($parser->valid());
        $this->assertEquals('user.name', $parser->resolveKey());
    }

    public function testNextMovesToNextRow(): void
    {
        $parser = new DataParser($this->sampleData, $this->rowHeader, $this->firstRow, $this->nameSeparator);

        $parser->rewind();
        $firstKey = $parser->resolveKey();

        $parser->next();
        $secondKey = $parser->resolveKey();

        $this->assertNotEquals($firstKey, $secondKey);
        $this->assertEquals('user.email', $secondKey);
    }

    public function testInvalidLocalesAreNotIncluded(): void
    {
        $dataWithInvalidLocales = [
            ['key', 'es', 'invalid', 'en_US', '123', 'fr'],
            ['test', 'Prueba', 'Invalid', 'Test', '123', 'Test'],
        ];

        $parser = new DataParser($dataWithInvalidLocales, 0, 0, '.');
        $locales = $parser->getLocales();

        $this->assertContains('es', $locales);
        $this->assertContains('en_US', $locales);
        $this->assertContains('fr', $locales);
        $this->assertNotContains('invalid', $locales);
        $this->assertNotContains('123', $locales);
    }
}
