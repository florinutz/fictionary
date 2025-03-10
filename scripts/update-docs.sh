#!/usr/bin/env bash

# update-docs.sh - A script to update documentation from langchain-core and langgraph repositories
#
# This script extracts version information from deno.json and fetches documentation
# from the respective GitHub repositories if it doesn't already exist locally.
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

# Function to extract version from deno.json
extract_version() {
    local package=$1
    grep -o "@$package@\^[0-9.]*" deno.json | sed "s/@$package@\^//"
}

# Function to update documentation for a specific package
update_docs_for_package() {
    local package=$1
    local version=$2
    local repo_url=$3
    local source_path=$4
    local target_dir=$5
    local force=$6

    log "INFO" "Checking $package documentation..."

    if [ -d "$target_dir" ] && [ "$force" != "true" ]; then
        log "INFO" "$package v$version documentation already exists."
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

    # Extract versions with multiple fallback mechanisms
    log "INFO" "Extracting version information..."

    local langchain_core_version=""
    local langgraph_version=""

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

    # Method 1: Direct extraction from deno.json (most reliable)
    log "INFO" "Trying method 1: Direct extraction from deno.json"
    # Extract langchain/core version
    local temp_core_version
    temp_core_version=$(grep -o '@langchain/core@\^[0-9.]*' deno.json | sed 's/@langchain\/core@\^//')
    if [ -n "$temp_core_version" ] && validate_version "$temp_core_version" "langchain-core"; then
        langchain_core_version=$temp_core_version
        log "INFO" "Found langchain-core version using method 1: $langchain_core_version"
    fi

    # Extract langgraph version
    local temp_graph_version
    temp_graph_version=$(grep -o '@langchain/langgraph@\^[0-9.]*' deno.json | sed 's/@langchain\/langgraph@\^//')
    if [ -n "$temp_graph_version" ] && validate_version "$temp_graph_version" "langgraph"; then
        langgraph_version=$temp_graph_version
        log "INFO" "Found langgraph version using method 1: $langgraph_version"
    fi

    # Method 2: Try to get exact versions currently in use with deno info --json (fallback)
    if [ -z "$langchain_core_version" ] || [ -z "$langgraph_version" ]; then
        if command -v deno &> /dev/null; then
            log "INFO" "Trying method 2: deno info --json src/main.ts"
            local deno_info
            if deno_info=$(deno info --json src/main.ts 2>/dev/null); then
                # Extract langchain/core version if not already found
                if [ -z "$langchain_core_version" ]; then
                    local temp_core_version
                    temp_core_version=$(echo "$deno_info" | grep -o '"@langchain/core@[0-9.]*"' | head -1 | sed 's/"@langchain\/core@\([0-9.]*\)"/\1/')
                    if [ -n "$temp_core_version" ] && validate_version "$temp_core_version" "langchain-core"; then
                        langchain_core_version=$temp_core_version
                        log "INFO" "Found langchain-core version using method 2: $langchain_core_version"
                    fi
                fi

                # Extract langgraph version if not already found
                if [ -z "$langgraph_version" ]; then
                    local temp_graph_version
                    temp_graph_version=$(echo "$deno_info" | grep -o '"@langchain/langgraph@[0-9.]*"' | head -1 | sed 's/"@langchain\/langgraph@\([0-9.]*\)"/\1/')
                    if [ -n "$temp_graph_version" ] && validate_version "$temp_graph_version" "langgraph"; then
                        langgraph_version=$temp_graph_version
                        log "INFO" "Found langgraph version using method 2: $langgraph_version"
                    fi
                fi
            else
                log "WARN" "Method 2 failed: Could not get info from deno info --json command"
            fi
        else
            log "WARN" "Method 2 skipped: Deno command not found"
        fi
    fi

    # Final check to ensure we have valid versions
    if [ -z "$langchain_core_version" ] || [ -z "$langgraph_version" ]; then
        log "ERROR" "Failed to extract valid versions after trying all methods"
        exit 1
    fi

    log "INFO" "Using versions: langchain-core=$langchain_core_version, langgraph=$langgraph_version"
    # Update langchain-core documentation
    update_docs_for_package \
        "langchain-core" \
        "$langchain_core_version" \
        "https://github.com/langchain-ai/langchainjs" \
        "docs/core_docs/docs" \
        "docs/langchain-core-$langchain_core_version" \
        "$force"

    # Update langgraph documentation
    update_docs_for_package \
        "langgraph" \
        "$langgraph_version" \
        "https://github.com/langchain-ai/langgraphjs" \
        "docs/docs" \
        "docs/langgraph-$langgraph_version" \
        "$force"

    log "INFO" "Documentation update complete."
}

# Execute main function
main "$@"
