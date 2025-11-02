Spreadsheet Translator Core
============================

The "Spreeadsheet Translator Core" contains the core library for the Spreadsheet Translator functionallity

Symfony Bundle:
- <a href="https://github.com/samuelvi/spreadsheet-translator-symfony-bundle">Symfony Bundle</a>

Symfony Demos:

- <a href="https://github.com/samuelvi/translator-symfony-demo-local-file-to-php">Symfony Demo. Takes a local file and creates translation files per locale in php format</a>
- <a href="https://github.com/samuelvi/translator-symfony-demo-google-drive-provider-yml-exporter">Symfony Demo. Takes a google drive spreadsheet and creates translation files per locale in yml format</a>
- <a href="https://github.com/samuelvi/translator-symfony-demo-google-auth-to-php">Symfony Demo. Takes an **authenticated** google drive spreadsheet and creates translation files per locale in php format</a>
- <a href="https://github.com/samuelvi/translator-symfony-demo-onedrive-to-xliff/">Symfony Demo. Takes a microsoft one drive spreadsheet and creates translation files per locale in xliff format</a>

Exporters:

- <a href="https://github.com/samuelvi/spreadsheet-translator-exporter-yml">Yml exporter</a>
- <a href="https://github.com/samuelvi/spreadsheet-translator-exporter-php">Php exporter</a>
- <a href="https://github.com/samuelvi/spreadsheet-translator-exporter-xliff">Xliff exporter</a>

Providers:
- <a href="https://github.com/samuelvi/spreadsheet-translator-provider-localfile">Local file</a>
- <a href="https://github.com/samuelvi/spreadsheet-translator-provider-googledrive">Google drive</a>

Readers:

- <a href="https://github.com/samuelvi/spreadsheet-translator-reader-xlsx">Xlsx</a>
- <a href="https://github.com/samuelvi/spreadsheet-translator-reader-matrix">Matrix</a>



Requirements
------------

  * PHP >=8.4

## Testing

This project includes a comprehensive test suite with both unit and integration tests.

### Running Tests

```bash
# Run all tests
composer test

# Run with coverage report
composer test:coverage

# Run PHPStan static analysis
composer phpstan

# Run all quality checks (tests + phpstan)
composer check
```

See [tests/README.md](tests/README.md) for detailed testing documentation.

### Continuous Integration

The project uses GitHub Actions for automated testing. All tests, code quality checks, and static analysis run automatically on:
- Push to main/master/develop branches
- Pull requests

## Code Quality Tools

This project uses **Rector** to maintain code quality and ensure compatibility with PHP 8.4.

### Rector Commands

To preview the changes Rector would make without modifying files (dry-run):

```bash
vendor/bin/rector process --dry-run
```

To apply Rector changes automatically:

```bash
vendor/bin/rector process
```

### Rector Configuration

The Rector configuration file (`rector.php`) is set up to:
- Upgrade code to PHP 8.4 standards
- Add strict type declarations to all PHP files
- Improve code quality and remove dead code
- Add type declarations where possible

Contributing
------------

We welcome contributions to this project, including pull requests and issues (and discussions on existing issues).

If you'd like to contribute code but aren't sure what, the issues list is a good place to start. If you're a first-time code contributor, you may find Github's guide to <a href="https://guides.github.com/activities/forking/">forking projects</a> helpful.

All contributors (whether contributing code, involved in issue discussions, or involved in any other way) must abide by our code of conduct.

License
-------

SpreadsheetTranslator is licensed under the MIT License. See the LICENSE file for full details.
