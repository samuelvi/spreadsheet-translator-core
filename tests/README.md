# Tests

This directory contains the test suite for the SpreadsheetTranslator Core library.

## Structure

```
tests/
├── Unit/              # Unit tests for individual classes
│   ├── Parser/        # Parser-related tests
│   ├── Util/          # Utility classes tests
│   ├── Exporter/      # Exporter tests
│   ├── Provider/      # Provider tests
│   └── Configuration/ # Configuration tests
├── Integration/       # Integration tests
├── Fixtures/          # Test data and fixtures
│   ├── data/          # PHP data fixtures
│   └── spreadsheets/  # Sample spreadsheet files
└── bootstrap.php      # Test bootstrap file
```

## Running Tests

### Run all tests
```bash
composer test
```

### Run specific test suites
```bash
# Unit tests only
vendor/bin/phpunit tests/Unit

# Integration tests only
vendor/bin/phpunit tests/Integration

# Specific test file
vendor/bin/phpunit tests/Unit/Parser/DataParserTest.php
```

### Code Coverage
```bash
# Generate HTML coverage report
composer test:coverage

# View coverage report
open coverage/index.html
```

## Code Quality

### Run PHPStan
```bash
composer phpstan
```

### Run Rector (check)
```bash
composer rector
```

### Run Rector (fix)
```bash
composer rector:fix
```

### Run all checks
```bash
composer check
```

## Writing Tests

### Unit Tests
Unit tests should focus on testing individual classes in isolation. Use mocks for dependencies.

Example:
```php
use PHPUnit\Framework\TestCase;

class MyClassTest extends TestCase
{
    public function testSomething(): void
    {
        // Arrange
        $instance = new MyClass();

        // Act
        $result = $instance->doSomething();

        // Assert
        $this->assertEquals('expected', $result);
    }
}
```

### Integration Tests
Integration tests verify that multiple components work together correctly.

### Fixtures
Use fixtures from `tests/Fixtures/data/SampleData.php` for consistent test data.

## CI/CD

Tests run automatically on GitHub Actions for:
- Every push to main/master/develop branches
- Every pull request

The CI pipeline runs:
1. PHPUnit tests with coverage
2. PHPStan static analysis (level 8)
3. Rector code quality checks

## Requirements

- PHP >= 8.4
- PHPUnit ^11.0
- Mockery ^1.6
- PHPStan ^2.0
