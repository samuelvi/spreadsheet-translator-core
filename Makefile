.PHONY: setup test

setup:
	composer install

test:
	vendor/bin/phpunit --no-coverage
