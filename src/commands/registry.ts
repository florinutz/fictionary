/**
 * Command registry
 * This module provides a registry for commands and a mechanism for discovering and registering commands
 */

import { Command } from '../deps.ts';
import { CommandDefinition } from '../types/command.ts';
import { logger } from '../lib/logger.ts';

/**
 * Command registry class
 * Manages the registration and discovery of commands
 */
export class CommandRegistry {
  /**
   * Map of command names to command definitions
   */
  private commands = new Map<string, CommandDefinition>();

  /**
   * Register a command with the registry
   * @param command The command to register
   */
  register(command: CommandDefinition): void {
    if (this.commands.has(command.name)) {
      logger.warn(`Command ${command.name} is already registered. Overwriting.`);
    }
    this.commands.set(command.name, command);
    logger.debug(`Registered command: ${command.name}`);
  }

  /**
   * Get a command by name
   * @param name The name of the command to get
   * @returns The command definition, or undefined if not found
   */
  getCommand(name: string): CommandDefinition | undefined {
    return this.commands.get(name);
  }

  /**
   * Get all registered commands
   * @returns An array of all registered command definitions
   */
  getAllCommands(): CommandDefinition[] {
    return Array.from(this.commands.values());
  }

  /**
   * Initialize all commands on the CLI program
   * @param program The CLI program to initialize commands on
   * @returns The CLI program with commands initialized
   */
  initializeCommands(program: Command): Command {
    for (const command of this.commands.values()) {
      const cmd = new Command()
        .name(command.name)
        .description(command.description);

      // Set up the command with its arguments and options
      const configuredCmd = command.setup(cmd);

      // Set the action handler
      // Use type assertion to handle the action handler compatibility
      configuredCmd.action((...args: unknown[]) => {
        return command.action.apply(null, args as [Record<string, unknown>, ...string[]]);
      });

      // Add the command to the program
      program.command(command.name, configuredCmd);

      logger.debug(`Initialized command: ${command.name}`);
    }

    return program;
  }

  /**
   * Discover and register commands from a directory
   * @param directory The directory to discover commands from
   */
  async discoverCommands(directory: string): Promise<void> {
    try {
      for await (const entry of Deno.readDir(directory)) {
        if (entry.isFile && entry.name.endsWith('.ts') && entry.name !== 'index.ts' && entry.name !== 'registry.ts') {
          const modulePath = `${directory}/${entry.name}`;
          try {
            const module = await import(modulePath);

            // Look for exported command definitions
            for (const [exportName, exportValue] of Object.entries(module)) {
              if (
                exportName.endsWith('Command') && 
                typeof exportValue === 'object' && 
                exportValue !== null &&
                'name' in exportValue &&
                'description' in exportValue &&
                'setup' in exportValue &&
                'action' in exportValue
              ) {
                this.register(exportValue as CommandDefinition);
              }
            }
          } catch (error) {
            const errorMessage = error instanceof Error ? error.message : String(error);
            logger.error(`Error importing command module ${modulePath}: ${errorMessage}`);
          }
        }
      }
    } catch (error) {
      const errorMessage = error instanceof Error ? error.message : String(error);
      logger.error(`Error discovering commands in ${directory}: ${errorMessage}`);
    }
  }
}

/**
 * Singleton instance of the command registry
 */
export const commandRegistry = new CommandRegistry();
