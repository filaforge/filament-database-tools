# Contributing to Filaforge Database Tools

Thank you for your interest in contributing to Filaforge Database Tools! This document provides guidelines and information for contributors.

## 🤝 How to Contribute

### Reporting Bugs

- Use the [GitHub issue tracker](https://github.com/filaforge/database-tools/issues)
- Include a clear description of the bug
- Provide steps to reproduce the issue
- Include your environment details (PHP version, Laravel version, Filament version)

### Suggesting Features

- Create a feature request issue
- Describe the feature and its benefits
- Provide use cases and examples
- Consider implementation complexity

### Code Contributions

1. **Fork the repository**
2. **Create a feature branch**: `git checkout -b feature/your-feature-name`
3. **Make your changes**
4. **Add tests** for new functionality
5. **Ensure code quality**:
   - Follow PSR-12 coding standards
   - Add proper PHPDoc comments
   - Write meaningful commit messages
6. **Submit a pull request**

## 🏗️ Development Setup

### Prerequisites

- PHP 8.1+
- Composer
- Node.js 16+
- Laravel 12.x
- Filament 4.x

### Local Development

1. **Clone your fork**:
   ```bash
   git clone https://github.com/your-username/database-tools.git
   cd database-tools
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Link to a Laravel project** for testing:
   ```bash
   # In your Laravel project's composer.json
   "repositories": [
       {
           "type": "path",
           "url": "../database-tools"
       }
   ]
   ```

4. **Build assets**:
   ```bash
   npm run build
   ```

## 📝 Coding Standards

### PHP Code

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standards
- Use type hints and return types
- Add comprehensive PHPDoc comments
- Keep methods small and focused
- Use meaningful variable and method names

### Blade Templates

- Use consistent indentation (4 spaces)
- Follow Laravel naming conventions
- Keep templates simple and readable
- Use proper escaping for user input

### CSS/JavaScript

- Follow Tailwind CSS conventions
- Use consistent naming patterns
- Keep styles modular and reusable
- Minimize JavaScript complexity

## 🧪 Testing

### Writing Tests

- Write tests for all new functionality
- Test both success and failure scenarios
- Use descriptive test method names
- Mock external dependencies

### Running Tests

```bash
# Run all tests
composer test

# Run with coverage
composer test -- --coverage

# Run specific test file
vendor/bin/phpunit tests/Feature/DatabaseToolsTest.php
```

## 📚 Documentation

### Code Documentation

- Document all public methods and classes
- Include usage examples
- Explain complex logic
- Keep documentation up-to-date

### User Documentation

- Update README.md for new features
- Add configuration examples
- Include troubleshooting guides
- Provide migration guides for updates

## 🔄 Pull Request Process

### Before Submitting

1. **Ensure tests pass**: `composer test`
2. **Check code quality**: `composer stan` (if configured)
3. **Update documentation** if needed
4. **Squash commits** if you have multiple commits

### Pull Request Guidelines

- **Clear title** describing the change
- **Detailed description** of what was changed and why
- **Reference issues** that are being addressed
- **Include screenshots** for UI changes
- **Add tests** for new functionality

### Review Process

- All PRs require at least one review
- Address review comments promptly
- Maintainers may request changes
- PRs are merged after approval

## 🏷️ Versioning

We follow [Semantic Versioning](https://semver.org/):

- **MAJOR**: Breaking changes
- **MINOR**: New features (backward compatible)
- **PATCH**: Bug fixes (backward compatible)

## 📋 Issue Templates

### Bug Report Template

```markdown
## Bug Description
Brief description of the bug

## Steps to Reproduce
1. Step one
2. Step two
3. Step three

## Expected Behavior
What should happen

## Actual Behavior
What actually happens

## Environment
- PHP Version:
- Laravel Version:
- Filament Version:
- Database:
- OS:

## Additional Information
Any other relevant information
```

### Feature Request Template

```markdown
## Feature Description
Brief description of the feature

## Use Cases
How would this feature be used?

## Benefits
What benefits would this feature provide?

## Implementation Ideas
Any thoughts on how to implement this?

## Additional Information
Any other relevant information
```

## 🆘 Getting Help

### Questions and Discussion

- Use [GitHub Discussions](https://github.com/filaforge/database-tools/discussions)
- Ask questions in issues
- Join our community channels

### Communication Guidelines

- Be respectful and inclusive
- Use clear and concise language
- Provide context for questions
- Help other contributors when possible

## 🙏 Recognition

Contributors will be:

- Listed in the README.md file
- Mentioned in release notes
- Added to the contributors list
- Recognized for significant contributions

## 📄 License

By contributing, you agree that your contributions will be licensed under the same license as the project (MIT License).

---

Thank you for contributing to Filaforge Database Tools! 🚀
