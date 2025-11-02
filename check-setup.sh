#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo "==========================================="
echo "Checking SpreadsheetTranslator Core Setup"
echo "==========================================="
echo ""

# Check PHP version
echo -n "Checking PHP version... "
PHP_VERSION=$(php -r "echo PHP_VERSION;")
if php -r "exit(version_compare(PHP_VERSION, '8.4', '<') ? 1 : 0);"; then
    echo -e "${GREEN}✓${NC} PHP $PHP_VERSION"
else
    echo -e "${RED}✗${NC} PHP version must be >= 8.4 (current: $PHP_VERSION)"
    exit 1
fi

# Check if vendor directory exists
echo -n "Checking if dependencies are installed... "
if [ -d "vendor" ]; then
    echo -e "${GREEN}✓${NC} vendor/ exists"
else
    echo -e "${RED}✗${NC} vendor/ not found. Run: composer install"
    exit 1
fi

# Check PHPUnit installation
echo -n "Checking PHPUnit installation... "
if [ -f "vendor/bin/phpunit" ]; then
    PHPUNIT_VERSION=$(vendor/bin/phpunit --version | grep -o 'PHPUnit [0-9.]*' | cut -d' ' -f2)
    echo -e "${GREEN}✓${NC} PHPUnit $PHPUNIT_VERSION"
else
    echo -e "${RED}✗${NC} PHPUnit not found"
    exit 1
fi

# Check PHPStan installation
echo -n "Checking PHPStan installation... "
if command -v vendor/bin/phpstan &> /dev/null; then
    PHPSTAN_VERSION=$(vendor/bin/phpstan --version | grep -o 'PHPStan [0-9.]*' | cut -d' ' -f2)
    echo -e "${GREEN}✓${NC} PHPStan $PHPSTAN_VERSION"
else
    echo -e "${RED}✗${NC} PHPStan not found"
    exit 1
fi

# Check Rector installation
echo -n "Checking Rector installation... "
if [ -f "vendor/bin/rector" ]; then
    echo -e "${GREEN}✓${NC} Rector installed"
else
    echo -e "${RED}✗${NC} Rector not found"
    exit 1
fi

# Check test directory structure
echo -n "Checking test directory structure... "
if [ -d "tests/Unit" ] && [ -d "tests/Integration" ] && [ -d "tests/Fixtures" ]; then
    echo -e "${GREEN}✓${NC} Test directories exist"
else
    echo -e "${RED}✗${NC} Test directory structure incomplete"
    exit 1
fi

# Check configuration files
echo -n "Checking configuration files... "
CONFIG_FILES=("phpunit.xml" "phpstan.neon" ".github/workflows/ci.yml")
MISSING=0
for file in "${CONFIG_FILES[@]}"; do
    if [ ! -f "$file" ]; then
        echo -e "${RED}✗${NC} Missing: $file"
        MISSING=1
    fi
done
if [ $MISSING -eq 0 ]; then
    echo -e "${GREEN}✓${NC} All configuration files present"
fi

echo ""
echo "==========================================="
echo "Running Tests..."
echo "==========================================="
echo ""

# Run tests
composer test

TEST_EXIT_CODE=$?

echo ""
echo "==========================================="
echo "Running PHPStan..."
echo "==========================================="
echo ""

# Run PHPStan
composer phpstan

PHPSTAN_EXIT_CODE=$?

echo ""
echo "==========================================="
echo "Summary"
echo "==========================================="
echo ""

if [ $TEST_EXIT_CODE -eq 0 ]; then
    echo -e "Tests: ${GREEN}✓ PASSED${NC}"
else
    echo -e "Tests: ${RED}✗ FAILED${NC}"
fi

if [ $PHPSTAN_EXIT_CODE -eq 0 ]; then
    echo -e "PHPStan: ${GREEN}✓ PASSED${NC}"
else
    echo -e "PHPStan: ${RED}✗ FAILED${NC}"
fi

echo ""

if [ $TEST_EXIT_CODE -eq 0 ] && [ $PHPSTAN_EXIT_CODE -eq 0 ]; then
    echo -e "${GREEN}All checks passed! ✓${NC}"
    exit 0
else
    echo -e "${RED}Some checks failed! ✗${NC}"
    exit 1
fi
