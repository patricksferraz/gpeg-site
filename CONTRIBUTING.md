# Contributing to GPEG

Thank you for your interest in contributing to GPEG! This document provides guidelines and instructions for contributing to this project.

## Code of Conduct

By participating in this project, you agree to abide by our [Code of Conduct](CODE_OF_CONDUCT.md). Please read it before contributing.

## How to Contribute

### Reporting Bugs

- Check if the bug has already been reported in the Issues section.
- If not, create a new issue with a clear title and description.
- Include steps to reproduce the bug, expected behavior, and any relevant screenshots or logs.

### Suggesting Enhancements

- Check if the enhancement has already been suggested in the Issues section.
- If not, create a new issue with a clear title and description.
- Explain why this enhancement would be useful and how it should work.

### Pull Requests

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Make your changes, following the coding standards.
4. Write or update tests as necessary.
5. Ensure all tests pass.
6. Submit a pull request with a clear title and description.

## Coding Standards

- Follow the PSR-12 coding standards for PHP.
- Use meaningful variable and function names.
- Write comments for complex logic.
- Keep your code DRY (Don't Repeat Yourself).

## Development Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/patricksferraz/gpeg-site.git
   cd gpeg-site
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up your environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Start the development server:
   ```bash
   php artisan serve
   ```

## Testing

- Write tests for new features and bug fixes.
- Run tests using:
  ```bash
  php artisan test
  ```

## License

By contributing to GPEG, you agree that your contributions will be licensed under the project's MIT License.
