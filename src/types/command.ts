/**
 * Command type definitions
 * This file defines the interfaces for command registration and execution
 */

import { Command } from '../deps.ts';

/**
 * Base command interface
 * All commands should implement this interface
 */
export interface CommandDefinition {
    /**
     * Command name
     */
    name: string;

    /**
     * Command description
     */
    description: string;

    /**
     * Setup method to configure the command
     * @param program The command instance to configure
     * @returns The configured command
     */
    setup: (program: Command) => Command;

    /**
     * Action method to execute when the command is invoked
     * @param args Command arguments and options
     */
    action: (options: Record<string, unknown>, ...inputs: string[]) => Promise<void> | void;
}
