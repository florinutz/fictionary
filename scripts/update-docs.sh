#!/usr/bin/env bash

# update-docs.sh - A script to update documentation from langchain-core and langgraph repositories
#
# This script extracts version information from deno.json and fetches documentation
# from the respective GitHub repositories if it doesn't already exist locally.
# Versions are stored in ./docs/.versions file.
#
# Usage: ./scripts/update-docs.sh [--force]
#   --force: Force update even if documentation already exists

set -e  # Exit immediately if a command exits with a non-zero status

# Function to display usage information
usage() {
    echo "Usage: $0 [--force]"
    echo "  --force: Force update even if documentation already exists"
    exit 1
}

# Function to log messages with timestamp
log() {
    local level=$1
    shift
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] [$level] $*"
}

# Function to validate version format
validate_version() {
    local version=$1
    local package=$2
    if [[ $version =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
        log "INFO" "Valid $package version found: $version"
        return 0
    else
        log "WARN" "Invalid $package version format: $version"
        return 1
    fi
}

# Function to extract version
extract_version() {
    local package=$1
    local version=""
    local method=""

    # Method 1: Try to get exact versions currently in use with deno info --json (primary method)
    if command -v deno &> /dev/null; then
        local deno_info
        if deno_info=$(deno info --json src/main.ts 2>/dev/null); then
            version=$(echo "$deno_info" | grep -o "\"@langchain/$package@[0-9.]*\"" | head -1 | sed "s/\"@langchain\/$package@\([0-9.]*\)\"/\1/")
            if [ -n "$version" ] && [[ $version =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
                method="deno info"
            fi
        fi
    fi

    # Method 2: Direct extraction from deno.json (fallback)
    if [ -z "$version" ] || [ -z "$method" ]; then
        # Try with @langchain/ prefix
        version=$(grep -o "@langchain/$package@\^[0-9.]*" deno.json | sed "s/@langchain\/$package@\^//")

        # If not found, try without prefix
        if [ -z "$version" ]; then
            version=$(grep -o "@$package@\^[0-9.]*" deno.json | sed "s/@$package@\^//")
        fi

        if [ -n "$version" ] && [[ $version =~ ^[0-9]+\.[0-9]+\.[0-9]+$ ]]; then
            method="deno.json"
        fi
    fi

    # Check if we found a valid version
    if [ -n "$version" ] && [ -n "$method" ]; then
        log "INFO" "Found $package version $version using $method" >&2
        echo "$version"
        return 0
    fi

    log "ERROR" "Failed to extract $package version using any method" >&2
    return 1
}

# Function to read current version from .versions file
get_current_version() {
    local package=$1
    local versions_file="docs/.versions"

    if [ -f "$versions_file" ]; then
        grep "^$package=" "$versions_file" | cut -d= -f2
    fi
}

# Function to update .versions file
update_versions_file() {
    local package=$1
    local version=$2
    local versions_file="docs/.versions"

    # Create file if it doesn't exist
    if [ ! -f "$versions_file" ]; then
        touch "$versions_file"
    fi

    # Update or add the version
    if grep -q "^$package=" "$versions_file"; then
        # Use a temporary file to avoid sed issues with special characters
        local temp_file
        temp_file=$(mktemp)
        grep -v "^$package=" "$versions_file" > "$temp_file"
        echo "$package=$version" >> "$temp_file"
        mv "$temp_file" "$versions_file"
    else
        echo "$package=$version" >> "$versions_file"
    fi
}

# Function to update documentation for a specific package
update_docs_for_package() {
    local package=$1
    local version=$2
    local repo_url=$3
    local source_path=$4
    local target_dir=$5
    local force=$6
    local current_version

    log "INFO" "Checking $package documentation..."

    # Get current version from .versions file
    current_version=$(get_current_version "$package")

    # Check if update is needed
    if [ "$current_version" = "$version" ] && [ -d "$target_dir" ] && [ "$force" != "true" ]; then
        log "INFO" "$package documentation already up to date (v$version)."
        return 0
    fi

    log "INFO" "Fetching $package v$version documentation..."

    # Remove existing documentation if it exists
    rm -rf "$target_dir" 2>/dev/null || true

    # Create temporary directory
    local temp_dir
    temp_dir=$(mktemp -d)

    # Clone repository
    if ! git clone --depth 1 --branch main --single-branch "$repo_url" "$temp_dir"; then
        log "ERROR" "Failed to clone $repo_url"
        rm -rf "$temp_dir"
        return 1
    fi

    # Create target directory
    mkdir -p "$target_dir"

    # Move documentation
    if ! mv "$temp_dir/$source_path"/* "$target_dir/"; then
        log "ERROR" "Failed to move documentation from $temp_dir/$source_path to $target_dir"
        rm -rf "$temp_dir"
        return 1
    fi

    # Clean up
    rm -rf "$temp_dir"

    # Update versions file
    update_versions_file "$package" "$version"

    log "INFO" "$package documentation updated to v$version."
    return 0
}

# Main function
main() {
    local force=false

    # Parse command line arguments
    while [[ $# -gt 0 ]]; do
        case "$1" in
            --force)
                force=true
                shift
                ;;
            -h|--help)
                usage
                ;;
            *)
                log "ERROR" "Unknown option: $1"
                usage
                ;;
        esac
    done

    # Check if deno.json exists
    if [ ! -f "deno.json" ]; then
        log "ERROR" "deno.json not found in current directory"
        exit 1
    fi

    # Check if docs directory exists, create if not
    if [ ! -d "docs" ]; then
        mkdir -p docs
    fi

    log "INFO" "Updating documentation..."

    # Extract versions
    log "INFO" "Extracting version information..."

    # Extract langchain-core version
    local langchain_core_version
    langchain_core_version=$(extract_version "core")
    if [ -z "$langchain_core_version" ]; then
        log "ERROR" "Failed to extract langchain-core version"
        exit 1
    fi

    # Extract langgraph version
    local langgraph_version
    langgraph_version=$(extract_version "langgraph")
    if [ -z "$langgraph_version" ]; then
        log "ERROR" "Failed to extract langgraph version"
        exit 1
    fi

    log "INFO" "Using versions: langchain-core=$langchain_core_version, langgraph=$langgraph_version"

    # Update langchain-core documentation
    update_docs_for_package \
        "langchain-core" \
        "$langchain_core_version" \
        "https://github.com/langchain-ai/langchainjs" \
        "docs/core_docs/docs" \
        "docs/langchain-core" \
        "$force"

    # Update langgraph documentation
    update_docs_for_package \
        "langgraph" \
        "$langgraph_version" \
        "https://github.com/langchain-ai/langgraphjs" \
        "docs/docs" \
        "docs/langgraph" \
        "$force"

    log "INFO" "Documentation update complete."
}

# Execute main function
main "$@"
