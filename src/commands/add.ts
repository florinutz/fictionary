/**
 * Add command module
 * This module provides a command to add two numbers
 */

import { Command } from '../deps.ts';
import { logger } from '../lib/logger.ts';

/**
 * Adds two numbers and returns the result
 * @param a First number
 * @param b Second number
 * @returns The sum of a and b
 */
export function add(a: number, b: number): number {
    return a + b;
}

/**
 * Add command definition
 */
export const addCommand = new Command()
    .name('add')
    .description('Add two numbers')
    .arguments('<a:number> <b:number>')
    .action((_, a: number, b: number) => {
        logger.info(`${a} + ${b} = ${add(a, b)}`);
    });
