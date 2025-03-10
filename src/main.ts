/**
 * Main entry point for the application
 * This file sets up the CLI command structure and handles execution
 */

import { Command } from '$src/deps.ts';
import { addCommand } from '$src/commands/index.ts';

// Re-export the add function for backward compatibility
export { add } from '$src/commands/add.ts';

// Create the main CLI command
const cli = new Command()
    .name('fictionary')
    .version('0.1.0')
    .description('A modern CLI TypeScript application')
    .action(() => {
        // Display help information when no subcommand is provided
        cli.showHelp();
    });

// Add subcommands
cli.command('add', addCommand);

// Execute the CLI if this file is run directly
if (import.meta.main) {
    cli.parse(Deno.args);
}
