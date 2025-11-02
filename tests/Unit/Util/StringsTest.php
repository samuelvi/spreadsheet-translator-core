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

namespace Atico\SpreadsheetTranslator\Core\Tests\Unit\Util;

use Atico\SpreadsheetTranslator\Core\Util\Strings;
use PHPUnit\Framework\TestCase;

class StringsTest extends TestCase
{
    public function testCamelizeWithDefaultSeparator(): void
    {
        $result = Strings::camelize('hello_world');

        $this->assertEquals('HelloWorld', $result);
    }

    public function testCamelizeWithCustomSeparator(): void
    {
        $result = Strings::camelize('hello-world', '-');

        $this->assertEquals('HelloWorld', $result);
    }

    public function testCamelizeWithDotSeparator(): void
    {
        $result = Strings::camelize('user.profile.name', '.');

        $this->assertEquals('UserProfileName', $result);
    }

    public function testCamelizeWithMultipleWords(): void
    {
        $result = Strings::camelize('this_is_a_test_string');

        $this->assertEquals('ThisIsATestString', $result);
    }

    public function testCamelizeWithEmptyString(): void
    {
        $result = Strings::camelize('');

        $this->assertEquals('', $result);
    }

    public function testCamelizeWithSingleWord(): void
    {
        $result = Strings::camelize('hello');

        $this->assertEquals('Hello', $result);
    }

    public function testCamelizeWithNumbersInString(): void
    {
        $result = Strings::camelize('user_123_name');

        $this->assertEquals('User123Name', $result);
    }

    public function testCamelizePreservesNumbers(): void
    {
        $result = Strings::camelize('test_2_name');

        $this->assertEquals('Test2Name', $result);
    }

    public function testUncamelizeWithDefaultSeparator(): void
    {
        $result = Strings::uncamelize('HelloWorld');

        $this->assertEquals('hello_world', $result);
    }

    public function testUncamelizeWithCustomSeparator(): void
    {
        $result = Strings::uncamelize('HelloWorld', '-');

        $this->assertEquals('hello-world', $result);
    }

    public function testUncamelizeWithDotSeparator(): void
    {
        $result = Strings::uncamelize('UserProfileName', '.');

        $this->assertEquals('user.profile.name', $result);
    }

    public function testUncamelizeWithMultipleWords(): void
    {
        $result = Strings::uncamelize('ThisIsATestString');

        $this->assertEquals('this_is_a_test_string', $result);
    }

    public function testUncamelizeWithLowercaseString(): void
    {
        $result = Strings::uncamelize('hello');

        $this->assertEquals('hello', $result);
    }

    public function testUncamelizeWithEmptyString(): void
    {
        $result = Strings::uncamelize('');

        $this->assertEquals('', $result);
    }

    public function testUncamelizeWithNumbers(): void
    {
        $result = Strings::uncamelize('User123Name');

        $this->assertEquals('user123_name', $result);
    }

    public function testUncamelizeWithPascalCase(): void
    {
        $result = Strings::uncamelize('PascalCaseString');

        $this->assertEquals('pascal_case_string', $result);
    }

    public function testCamelizeAndUncamelizeAreInverse(): void
    {
        $original = 'hello_world_test';
        $camelized = Strings::camelize($original);
        $uncamelized = Strings::uncamelize($camelized);

        $this->assertEquals($original, $uncamelized);
    }

    public function testCamelizeWithConsecutiveSeparators(): void
    {
        $result = Strings::camelize('hello__world');

        // Should handle empty parts between separators
        $this->assertStringContainsString('Hello', $result);
        $this->assertStringContainsString('World', $result);
    }

    public function testUncamelizeDoesNotAffectLeadingUppercase(): void
    {
        $result = Strings::uncamelize('TestString');

        // First letter should be lowercase in result
        $this->assertEquals('test_string', $result);
    }

    public function testCamelizeWithSpecialCharacters(): void
    {
        $result = Strings::camelize('hello_world!');

        $this->assertStringContainsString('Hello', $result);
        $this->assertStringContainsString('World', $result);
    }

    public function testUncamelizeWithAcronyms(): void
    {
        $result = Strings::uncamelize('XMLParser');

        $this->assertEquals('x_m_l_parser', $result);
    }

    public function testCamelizeWithTrailingSeparator(): void
    {
        $result = Strings::camelize('hello_world_');

        $this->assertStringStartsWith('Hello', $result);
        $this->assertStringContainsString('World', $result);
    }

    public function testCamelizeWithLeadingSeparator(): void
    {
        $result = Strings::camelize('_hello_world');

        $this->assertStringContainsString('Hello', $result);
        $this->assertStringContainsString('World', $result);
    }
}
