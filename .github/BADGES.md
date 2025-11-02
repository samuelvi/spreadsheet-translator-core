# Badges for README

Add these badges to your README.md to show build status and code coverage:

```markdown
[![CI](https://github.com/samuelvi/spreadsheet-translator-core/actions/workflows/ci.yml/badge.svg)](https://github.com/samuelvi/spreadsheet-translator-core/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/samuelvi/spreadsheet-translator-core/branch/master/graph/badge.svg)](https://codecov.io/gh/samuelvi/spreadsheet-translator-core)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.4-blue.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
```

## Setup Instructions

### Codecov Integration
1. Go to https://codecov.io/
2. Sign in with your GitHub account
3. Add your repository
4. Get the upload token
5. Add the token as a GitHub Secret named `CODECOV_TOKEN` in your repository settings

### GitHub Actions
The CI workflow is already configured in `.github/workflows/ci.yml` and will run automatically on push and pull requests.
