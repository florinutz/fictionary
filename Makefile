.PHONY: all start dev test test-watch lint format check build clean cache help

all: lint format check test #build

start:
	deno task start

dev:
	deno task dev

test:
	deno task test

test-watch:
	deno task test:watch

lint:
	deno task lint

format:
	deno task fmt

check:
	deno task check

build:
	deno task compile

clean:
	rm -rf dist

cache:
	deno task cache

help:
	@echo "Available targets:"
	@echo "  start        - Run the application"
	@echo "  dev          - Run the application with watch mode"
	@echo "  test         - Run all tests"
	@echo "  test-watch   - Run tests in watch mode"
	@echo "  lint         - Run linter"
	@echo "  format       - Format code"
	@echo "  check        - Type check the code"
	@echo "  build        - Build executable"
	@echo "  clean        - Remove build artifacts"
	@echo "  cache        - Update dependency cache"
	@echo "  all          - Run lint, format, check, test, and build"
	@echo "  help         - Show this help message"