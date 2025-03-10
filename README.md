# Fictionary

A modern CLI TypeScript application built with Deno.

## Features

- Modern TypeScript codebase
- Command-line interface using Cliffy
- Comprehensive testing infrastructure
- Dependency management with deps.ts
- Build automation with Makefile

## Installation

### Prerequisites

- [Deno](https://deno.com/) 1.37 or later

### Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/fictionary.git
   cd fictionary
   ```

2. Cache dependencies:
   ```bash
   make cache
   ```

## Usage

### Running the Application

```bash
# Run the application
make start

# Run with watch mode for development
make dev
```

### Available Commands

```bash
# Show help information
deno run src/main.ts

# Add two numbers
deno run src/main.ts add 2 3
```

## Development

### Development Workflow

1. Make code changes
2. Format code:
   ```bash
   make format
   ```
3. Lint code:
   ```bash
   make lint
   ```
4. Type check:
   ```bash
   make check
   ```
5. Run tests:
   ```bash
   make test
   ```
6. For rapid development with auto-reload:
   ```bash
   make dev
   ```

### Project Structure

```
fictionary/
├── .github/                    # GitHub workflows for CI/CD
├── src/
│   ├── commands/               # CLI command modules
│   ├── lib/                    # Shared utilities and core functionality
│   ├── types/                  # TypeScript type definitions
│   ├── main.ts                 # Entry point
│   └── deps.ts                 # Centralized dependencies
├── tests/
│   ├── unit/                   # Unit tests
│   ├── integration/            # Integration tests
│   └── fixtures/               # Test fixtures
├── scripts/                    # Build and utility scripts
├── deno.json                   # Deno configuration
├── Makefile                    # Build automation
└── README.md                   # Project documentation
```

### Building

To create a standalone executable:

```bash
make build
```

The executable will be created in the `dist` directory.

## License

[MIT](LICENSE)
