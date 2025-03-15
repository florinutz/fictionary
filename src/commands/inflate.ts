/**
 * Inflate command module
 * This module provides a command to convert unstructured text into a structured narrative bible
 */

import { Command } from '../deps.ts';
import { logger } from '../lib/logger.ts';
import { CommandDefinition } from '../types/command.ts';
import { workflowRegistry } from '../workflows/registry.ts';
import { OutputFormat } from '../types/workflow.ts';
import { NarrativeBible } from '../types/models/narrative.ts';

/**
 * Interface for inflate command options
 */
interface InflateOptions {
    outputFormat: OutputFormat;
    enrichmentLevel: 'basic' | 'standard' | 'detailed';
    categories?: string[];
    outputFile?: string;
}

/**
 * Inflate command definition
 * Implements the CommandDefinition interface
 */
export const inflateCommand: CommandDefinition = {
    name: 'inflate',
    description: 'Convert unstructured text into a structured narrative bible',

    setup(program: Command): Command {
        // Use type assertion to handle the command type compatibility
        // Convert to unknown first before asserting to Command
        return program
            .arguments('<input:string>')
            .option('-o, --output-format <format:string>', 'Output format (json, yaml, markdown)', {
                default: 'json',
            })
            .option(
                '-l, --enrichment-level <level:string>',
                'Level of detail (basic, standard, detailed)',
                {
                    default: 'standard',
                },
            )
            .option(
                '-c, --categories <categories:string[]>',
                'Categories to include (world, characters, magic, etc.)',
            )
            .option(
                '-o, --output-file <file:string>',
                'File to save the output to',
            ) as unknown as Command;
    },

    async action(options: Record<string, unknown>, ...inputs: string[]): Promise<void> {
        // Cast options to InflateOptions
        const inflateOptions = options as unknown as InflateOptions;
        const input = inputs[0] || '';
        try {
            logger.info(`Inflating input text with options: ${JSON.stringify(options)}`);

            // Get the inflation workflow from the registry
            const workflow = workflowRegistry.getWorkflow<string, NarrativeBible>('inflation');

            if (!workflow) {
                logger.error('Inflation workflow not found. Make sure it is registered.');
                return;
            }

            // Validate the input
            const validatedInput = workflow.validateInput(input);

            // Execute the workflow
            const result = await workflow.execute(validatedInput, {
                outputFormat: inflateOptions.outputFormat as OutputFormat,
                enrichmentLevel: inflateOptions.enrichmentLevel,
                categories: inflateOptions.categories,
            });

            // Format the output
            const formattedOutput = workflow.formatOutput(
                result,
                inflateOptions.outputFormat as OutputFormat,
            );

            // Save to file if specified
            if (inflateOptions.outputFile) {
                await Deno.writeTextFile(
                    inflateOptions.outputFile,
                    typeof formattedOutput === 'string'
                        ? formattedOutput
                        : JSON.stringify(formattedOutput, null, 2),
                );
                logger.info(`Output saved to ${inflateOptions.outputFile}`);
            } else {
                // Output to console via logger
                if (typeof formattedOutput === 'string') {
                    logger.info(formattedOutput);
                } else {
                    logger.info(JSON.stringify(formattedOutput, null, 2));
                }
            }

            logger.info('Inflation completed successfully');
        } catch (error) {
            const errorMessage = error instanceof Error ? error.message : String(error);
            logger.error(`Error during inflation: ${errorMessage}`);
            if (error instanceof Error && error.stack) {
                logger.debug(error.stack);
            }
        }
    },
};
