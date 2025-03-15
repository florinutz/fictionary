/**
 * Main entry point for the application
 * This file sets up the CLI command structure and handles execution
 */

import { Command } from '$src/deps.ts';
import { commandRegistry, inflateCommand } from '$src/commands/index.ts';
import { inflationWorkflow, workflowRegistry } from '$src/workflows/index.ts';
import { logger } from '$src/lib/logger.ts';

/**
 * Initialize the application
 * This function sets up the command and workflow registries
 * @returns void
 */
function initialize(): void {
    // Register commands
    commandRegistry.register(inflateCommand);

    // Register workflows
    workflowRegistry.register(inflationWorkflow);

    // Discover additional commands and workflows
    // In a real implementation, these would be discovered dynamically
    // Note: If these lines are uncommented, the function should be marked as async
    // await commandRegistry.discoverCommands('./src/commands');
    // await workflowRegistry.discoverWorkflows('./src/workflows');

    logger.info('Application initialized');
}

// Create the main CLI command
const cli = new Command()
    .name('fictionary')
    .version('0.1.0')
    .description('A CLI tool for creative writing assistance')
    .action(() => {
        // Display help information when no subcommand is provided
        cli.showHelp();
    });

// Initialize the application and set up commands
await initialize();
commandRegistry.initializeCommands(cli);

// Execute the CLI if this file is run directly
if (import.meta.main) {
    cli.parse(Deno.args);
}
